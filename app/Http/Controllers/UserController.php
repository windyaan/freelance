<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.client.index');
    }

    // Terima / Tolak offer dari freelancer
    // public function updateOfferStatus(Request $request, Offer $offer)
    // {
    //     if ($offer->client_id != Auth::id()) abort(403);

    //     $request->validate([
    //         'status' => 'in:accepted,declined',
    //     ]);

    //     $offer->update(['status' => $request->status]);

    //     return back()->with('success', 'Status penawaran berhasil diperbarui.');
    // }

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

    // Request revisi milestone (oleh client)
    public function requestMilestoneRevision(Request $request, $milestoneId)
    {
        $milestone = Milestone::findOrFail($milestoneId);
        $clientId = Auth::id();

        if ($milestone->offer->client_id != $clientId) abort(403);

        $request->validate([
            'message' => 'required|string'
        ]);

        // Update status milestone
        $milestone->update(['status' => 'revisi_request']);

        // Simpan pesan revisi ke chat sebagai message
        Message::create([
            'chat_id' => $milestone->offer->chat->id,
            'sender_id' => $clientId,
            'content' => $request->message,
        ]);

        return back()->with('success', 'Revisi berhasil dikirim ke freelancer.');
    }
}
