<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FreelancerController extends Controller
{
    public function index()
    {
        $freelancerId = Auth::id();

    // Ambil semua offer milik freelancer
    $offers = Offer::with(['job', 'client', 'milestones', 'orders'])
        ->where('freelancer_id', $freelancerId)
        ->latest()
        ->get();

    // Ambil semua order dari offer freelancer
    $orders = Order::with(['offer.job', 'offer.client'])
        ->whereHas('offer', function ($query) use ($freelancerId) {
            $query->where('freelancer_id', $freelancerId);
        })
        ->get();

        return view('dashboard.freelancer.index',compact('offers','orders'));
        }

    //mengecek apakah offer milik freelancer
    public function showOrderDetail(Offer $offer)
    {
        if ($offer->freelancer_id != Auth::id() && $offer->job->freelancer_id != Auth::id()) {
            abort(403);
        }

        return view('dashboard.freelancer.detail', compact('offer'));
    }

    //menambahkan milestone baru
        public function storeMilestone(Request $request, Offer $offer)
    {
        if ($offer->freelancer_id != Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $offer->milestones()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Start',
        ]);

        return back()->with('success', 'Milestone berhasil ditambahkan.');
    }

    //memperbarui milestone
    public function updateMilestone(Request $request, $milestoneId)
    {
        $milestone = \App\Models\Milestone::findOrFail($milestoneId);
        $freelancerId = Auth::id();

        if ($milestone->offer->freelancer_id != $freelancerId) abort(403);

        $request->validate([
            'status' => 'in:Start,Progress,Done,revisi_request,approved',
        ]);

        $milestone->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'Done' ? now() : null,
        ]);

        return back()->with('success', 'Status milestone diperbarui.');
    }
}

