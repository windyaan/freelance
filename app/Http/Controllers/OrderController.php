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
        $order = Order::whereHas('offer.job', function ($q) use ($user) {
            $q->where('client_id', $user->id);
        })->with(['offer.job.freelancer'])->get();

        return view('order.client.order', compact('order'));
    }

    // mengambil semua order milik freelance dari client
    public function freelancerIndex()
    {
        $freelancerId = Auth::user();

        $order = Order::whereHas('offer.job', function ($query) use ($freelancerId) {
            $query->where('freelancer_id', $freelancerId);
        })->with(['offer.job', 'client']) // eager load biar ga N+1
          ->get();

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

    // Method untuk show detail order - DIPERBAIKI
    public function show(Order $order)
    {
        $user = Auth::user();
        
        // Load relasi yang diperlukan
        $order->load(['offer.job.freelancer', 'offer.client']);

        // Cek authorization
        $isFreelancer = $user->role === 'freelancer' && $order->offer->freelancer_id === $user->id;
        $isClient = $user->role === 'client' && $order->offer->client_id === $user->id;
        
        if (!$isFreelancer && !$isClient) {
            abort(403, 'Unauthorized');
        }

        // PERBAIKAN: Redirect langsung ke milestones karena itu tujuan Anda
        return redirect()->route('milestones.showByOrder', $order->id);
        
        // ALTERNATIF: Jika tetap ingin tampilkan detail order, uncomment dan buat view:
        /*
        if ($isFreelancer) {
            return view('orders.freelancer.show', compact('order'));
        }
        
        if ($isClient) {
            return view('orders.client.show', compact('order'));
        }
        */
    }

    //Admin - Lihat semua order
    public function adminIndex()
    {
        $orders = Order::with(['offer.job.freelancer', 'offer.job.client'])->get();

        return view('dashboard.admin.orders.index', compact('orders'));
    }

    // Form pembayaran order
    public function showPayment(Order $order)
    {
        // Load relasi yang diperlukan
        $order->load(['offer.job.freelancer', 'offer.client']);
        
        // Cek authorization
        $user = Auth::user();
        if ($user->id !== $order->offer->client_id) {
            abort(403, 'Unauthorized');
        }
        
        return view('order.payment', compact('order'));
    }

    /**
     * Proses pembayaran manual
     */
    public function pay(Request $request, Order $order)
    {
        // Cek authorization
        $user = Auth::user();
        if ($user->id !== $order->offer->client_id) {
            abort(403, 'Unauthorized');
        }
        
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

        return redirect()->route('milestones.showByOrder', $order->id)
            ->with('success', 'Pembayaran berhasil diproses. Lihat progress project Anda.');
    }

    /**
     * Method untuk client melakukan pembayaran dari halaman order
     */
    public function makePayment(Request $request, Order $order)
    {
        return $this->pay($request, $order);
    }

    /**
     * Method untuk cancel order (jika diperlukan)
     */
    public function cancel(Order $order)
    {
        $user = Auth::user();
        if ($user->id !== $order->offer->client_id) {
            abort(403, 'Unauthorized');
        }

        // Logic untuk cancel order
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('client.order')->with('success', 'Order berhasil dibatalkan.');
    }

    /**
     * Download invoice (jika diperlukan)
     */
    public function downloadInvoice(Order $order)
    {
        $user = Auth::user();
        if ($user->id !== $order->offer->client_id) {
            abort(403, 'Unauthorized');
        }

        // Logic untuk generate dan download invoice
        // Untuk sekarang redirect ke detail
        return redirect()->route('milestones.showByOrder', $order->id);
    }
}