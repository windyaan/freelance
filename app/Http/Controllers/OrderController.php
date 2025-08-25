<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // mengambil semua order milik client
    public function clientIndex()
    {
        $user = Auth::user();

    // ambil semua order berdasarkan client lewat relasi offer -> job -> user
        $orders = Order::whereHas('offer.job', function ($q) use ($user) {
            $q->where('client_id', $user->id);
        })->with(['offer.job.freelancer'])->get();

        return view('order.client.order', compact('order'));
    }

    // mengambil semua order milik freelance dari client
    public function freelancerIndex()
    {
        $user = Auth::user();

        $orders = Order::whereHas('offer.job', function ($q) use ($user) {
            $q->where('freelancer_id', $user->id);
        })->with(['offer.job.client'])->get();

        return view('order.freelancer.order', compact('order'));
    }

    // Method umum index (untuk fallback atau direct access)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'freelancer') {
            return $this->freelancerIndex();
        } elseif ($user->role === 'client') {
            return $this->clientIndex();
        }

        abort(403); // role tidak dikenal
    }

    // Method untuk show detail order
    public function show(Order $order)
    {
        $user = Auth::user();

        if ($user->role === 'freelancer' && $order->offer->freelancer_id === $user->id) {
            return view('order.freelancer.show', compact('order'));
        }

        if ($user->role === 'client' && $order->offer->client_id === $user->id) {
            return view('order.client.show', compact('order'));
        }

        abort(403);
    }

    //Admin - Lihat semua order
    // public function adminIndex()
    // {
    //     $orders = Order::with(['offer.job.freelancer', 'offer.job.client'])->get();

    //     return view('dashboard.admin.orders.index', compact('orders'));
    // }

    // Form pembayaran order

    public function showPayment(Order $order)
    {
        return view('order.payment', compact('order'));
    }

    /**
     * Proses pembayaran manual
     */
    public function pay(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        // Cek agar tidak overpayment
    if ($request->amount > $order->remaining_amount) {
        return back()->withErrors(['amount' => 'Nominal pembayaran melebihi sisa tagihan.']);
    }

        // Tambahkan nominal pembayaran ke total amount_paid
        $order->amount_paid += $request->amount;
        $order->payment_method = $request->payment_method;

        // Tentukan status berdasarkan pembayaran
        if ($order->amount_paid < $order->amount) {
            $order->status = 'dp';
        } elseif ($order->amount_paid == $order->amount) {
            $order->status = 'paid';
        }

        $order->save();

        return redirect()->route('order.showPayment', $order->id)
            ->with('success', 'Pembayaran berhasil diproses.');
    }
}
