<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Method untuk client orders (dipanggil dari route client.orders)
    public function clientIndex()
    {
        $user = Auth::user();

        // Sementara menggunakan empty collection untuk testing
        // Uncomment baris di bawah jika model dan relationship sudah benar
        /*
        $orders = Order::whereHas('offer', function ($query) use ($user) {
            $query->where('client_id', $user->id);
        })->with('offer.freelancer', 'offer.job')->get();
        */
        
        $order = collect(); // Empty collection untuk testing

        return view('order.client.order', compact('order'));
    }

    // Method untuk freelancer orders (dipanggil dari route freelancer.orders)
    public function freelancerIndex()
    {
        $user = Auth::user();

        // Sementara menggunakan empty collection untuk testing
        // Uncomment baris di bawah jika model dan relationship sudah benar
        /*
        $orders = Order::whereHas('offer', function ($query) use ($user) {
            $query->where('freelancer_id', $user->id);
        })->with('offer.client', 'offer.job')->get();
        */
        
        $order = collect(); // Empty collection untuk testing

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

    // Method untuk create order (jika diperlukan)
    public function create($job = null)
    {
        return view('order.create', compact('job'));
    }

    // Method untuk store order
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'freelancer_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000'
        ]);

        // Logic untuk create order
        // $order = Order::create([...]);

        return redirect()->route('client.order')->with('success', 'Order created successfully');
    }

    // Method untuk payment (client)
    public function makePayment(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'client' || $order->offer->client_id !== $user->id) {
            abort(403);
        }

        // Logic untuk payment
        // Update order status, process payment, etc.

        return redirect()->back()->with('success', 'Payment processed successfully');
    }

    // Method untuk cancel order (client)
    public function cancel(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'client' || $order->offer->client_id !== $user->id) {
            abort(403);
        }

        // Logic untuk cancel order
        $order->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Order cancelled successfully');
    }

    // Method untuk accept order (freelancer)
    public function accept(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'freelancer' || $order->offer->freelancer_id !== $user->id) {
            abort(403);
        }

        // Logic untuk accept order
        $order->update(['status' => 'accepted']);
        
        return redirect()->back()->with('success', 'Order accepted successfully');
    }

    // Method untuk reject order (freelancer)
    public function reject(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'freelancer' || $order->offer->freelancer_id !== $user->id) {
            abort(403);
        }

        // Logic untuk reject order
        $order->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Order rejected successfully');
    }

    // Method untuk complete order (freelancer)
    public function complete(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'freelancer' || $order->offer->freelancer_id !== $user->id) {
            abort(403);
        }

        // Logic untuk complete order
        $order->update(['status' => 'completed']);
        
        return redirect()->back()->with('success', 'Order completed successfully');
    }

    // Method untuk upload deliverable (freelancer)
    public function uploadDeliverable(Request $request, Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'freelancer' || $order->offer->freelancer_id !== $user->id) {
            abort(403);
        }

        // Validate file
        $request->validate([
            'deliverable' => 'required|file|max:10240', // 10MB max
        ]);

        // Logic untuk upload file
        // $path = $request->file('deliverable')->store('deliverables');
        // $order->update(['deliverable_path' => $path]);
        
        return redirect()->back()->with('success', 'Deliverable uploaded successfully');
    }

    // Method untuk download invoice (client)
    public function downloadInvoice(Order $order)
    {
        $user = Auth::user();
        
        if ($user->role !== 'client' || $order->offer->client_id !== $user->id) {
            abort(403);
        }

        // Logic untuk generate dan download invoice
        // Generate PDF, return download response
        
        return response()->json(['message' => 'Invoice download functionality coming soon']);
    }
}