<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Offer;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function index()
    {
        //baru

        return view('dashboard.client.index');
    }

     // Client menerima offer
    public function acceptOffer($id)
    {
        $offer = Offer::findOrFail($id);

        // pastikan yang menerima offer adalah client yang dituju
        if ($offer->client_id !== Auth::id()) {
            abort(403);
        }

        // update status offer jadi accepted
        $offer->update(['status' => 'accepted']);

        // buat notifikasi untuk freelancer
        Notification::create([
        'user_id' => $offer->freelancer_id, // penerima notifikasi
        'type'    => 'offer',
        'content' => 'Offer kamu untuk job "' . $offer->job->title . '" telah diterima',
        'link_url'=> route('orders.show', $offer->id), // atau langsung ke order
        ]);

        // buat order baru dari offer dengn status pending
        $order = Order::create([
            'offer_id' => $offer->id,
            'amount' => $offer->final_price,
            'status' => 'pending', // default sebelum bayar
        ]);

        // Update semua milestone terkait → set start_time
        foreach ($offer->milestones as $milestone) {
        $milestone->update([
            'start_time' => now(),
        ]);
    }

        // redirect ke halaman transaksi
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Offer diterima, silakan lanjut ke transaksi.');
    }

    // Client menolak offer
    public function declineOffer($id)
    {
        $offer = Offer::findOrFail($id);

        if ($offer->client_id !== Auth::id()) {
            abort(403);
        }

        // ubah status jadi declined
        $offer->update(['status' => 'declined']);

        // tetap di halaman chat
        return redirect()->back()->with('info', 'Offer ditolak.');
    }
}
