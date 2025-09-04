<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilestoneController extends Controller
{
    /**
     * Tampilkan milestone untuk sebuah offer
     */
    public function index($offerId)
{
    $offer = Offer::with(['milestones', 'client', 'freelancer'])->findOrFail($offerId);

    // cek hak akses
    if (Auth::id() !== $offer->freelancer_id && Auth::id() !== $offer->client_id) {
        abort(403, 'Unauthorized');
    }

    // Ambil order untuk tampilan
    $order = Order::where('offer_id', $offerId)->first();
    $milestones = $offer->milestones()->orderBy('start_time')->get();

      return view('milestones.index', compact('offer', 'milestones'));

    }

    /**
     * Freelancer membuat milestone baru (default Start)
     */
    public function store(Request $request, $offerId)
    {
        $offer = Offer::findOrFail($offerId);

        if (Auth::id() !== $offer->freelancer_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $milestone = Milestone::create([
            'offer_id'    => $offer->id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'Start', // default ketika dibuat
            'start_time'  => now(),
        ]);

       return redirect()
    ->route('milestones.index', $offerId)
    ->with('success', 'Milestone berhasil dibuat.');
    }

    /**
     * Update milestone (ubah status)
     */
    public function update(Request $request, Milestone $milestone)
    {
        $offer = $milestone->offer;

        if (Auth::id() !== $offer->freelancer_id && Auth::id() !== $offer->client_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:Start,Progress,Done,revisi_request,approved',
        ]);

        $status = $request->status;

        // Hanya freelancer boleh Progress/Done
        if (in_array($status, ['Progress','Done']) && Auth::id() !== $offer->freelancer_id) {
            abort(403, 'Client tidak boleh ubah ke Progress/Done');
        }

        // Hanya client boleh revisi/approve
        if (in_array($status, ['revisi_request','approved']) && Auth::id() !== $offer->client_id) {
            abort(403, 'Freelancer tidak boleh ubah ke Revisi/Approve');
        }

        $data = ['status' => $status];

        // Kalau Done → set completed_at
        if ($status === 'Done') {
            $data['completed_at'] = now();
        }

        $milestone->update($data);

        return response()->json($milestone);
    }

    /**
     * Hapus milestone (opsional, hanya freelancer)
     */
    public function destroy(Milestone $milestone)
    {
        $offer = $milestone->offer;

        if (Auth::id() !== $offer->freelancer_id) {
            abort(403, 'Unauthorized');
        }

        $milestone->delete();

        return response()->json(['message' => 'Milestone deleted']);
    }

    public function showByOrder($orderId)
{
    $order = Order::with('offer.milestones', 'offer.client', 'offer.freelancer')
        ->findOrFail($orderId);

    $offer = $order->offer;

    // cek hak akses (hanya freelancer & client terkait)
    if (Auth::id() !== $offer->freelancer_id && Auth::id() !== $offer->client_id) {
        abort(403, 'Unauthorized');
    }

    return view('milestones.index', [
        'order' => $order,
        'offer' => $offer,
        'milestones' => $offer->milestones()->orderBy('start_time')->get(),
    ]);
}
}
