<?php
namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilestoneController extends Controller
{
    //membuat milestone baru ke dalam sebuah offer
    public function store(Request $request, Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        //menyimpan milestone
        $offer->milestones()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Start',
        ]);

        return back()->with('success', 'Milestone berhasil ditambahkan.');
    }

    public function update(Request $request, Milestone $milestone)
    {
        if ($milestone->offer->freelancer_id !== Auth::id()) abort(403);

        $request->validate([
            'status' => 'in:Start,Progress,Done,revisi_request,approved',
        ]);

        $milestone->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'Done' ? now() : null,
        ]);

        return back()->with('success', 'Status milestone diperbarui.');
    }

    //menampilkan detail dari satu milestone
    public function show($id)
    {
        $milestone = Milestone::with('offer.job')->findOrFail($id);
        if ($milestone->offer->freelancer_id !== Auth::id()) abort(403);

        return view('milestones.show', compact('milestone'));
    }
}
