<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // //menampilkan semua order
    // public function index()
    // {
    //     $orders = Order::whereHas('offer', function ($query) {
    //         $query->where('freelancer_id', Auth::id());
    //     })->with('offer.client', 'offer.job')->get();

    //     return view('orders.index', compact('orders'));
    // }

    // //menampilkan isi detail dari satu order,jika freelancer yg login pemilik offernya
    // public function show(Order $order)
    // {
    //     if ($order->offer->freelancer_id !== Auth::id()) abort(403);

    //     return view('orders.show', compact('order'));
    // }
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'freelancer') {
            $orders = Order::whereHas('offer', function ($query) use ($user) {
                $query->where('freelancer_id', $user->id);
            })->with('offer.client', 'offer.job')->get();

            return view('orders.freelancer.index', compact('orders'));

        } elseif ($user->role === 'client') {
            $orders = Order::whereHas('offer', function ($query) use ($user) {
                $query->where('client_id', $user->id);
            })->with('offer.freelancer', 'offer.job')->get();

            return view('orders.client.index', compact('orders'));
        }

        abort(403); // role tidak dikenal
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        if ($user->role === 'freelancer' && $order->offer->freelancer_id === $user->id) {
            return view('orders.freelancer.show', compact('order'));
        }

        if ($user->role === 'client' && $order->offer->client_id === $user->id) {
            return view('orders.client.show', compact('order'));
        }

        abort(403);
    }
}
