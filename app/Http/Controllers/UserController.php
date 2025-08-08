<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.client.index');
    }

    // Terima / Tolak offer dari freelancer
    public function updateOfferStatus(Request $request, Offer $offer)
    {
        if ($offer->client_id != Auth::id()) abort(403);

        $request->validate([
            'status' => 'in:accepted,declined',
        ]);

        $offer->update(['status' => $request->status]);

        return back()->with('success', 'Status penawaran berhasil diperbarui.');
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
