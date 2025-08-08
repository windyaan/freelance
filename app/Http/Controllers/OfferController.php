<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    //offer digunakan freelancer crud offer

    //menampilkan semua offer punya freelancer
    public function index()
    {
        $offers = Offer::where('freelancer_id', Auth::id())->with('client', 'job')->get();
        return view('offers.index', compact('offers'));
    }

    // menampilkan halaman form untuk create offer
    public function create()
    {
        return view('offers.create');
    }

    // Simpan offer baru
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'final_price' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
        ]);

        Offer::create([
            'job_id' => $request->job_id,
            'freelancer_id' => Auth::id(),
            'client_id' => $request->client_id, // harus disesuaikan
            'title' => $request->title,
            'description' => $request->description,
            'final_price' => $request->final_price,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        return redirect()->route('offers.index')->with('success', 'Offer berhasil dibuat');
    }

    // Edit offer
    public function edit(Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) abort(403);

        return view('offers.edit', compact('offer'));
    }

    // Update offer
    public function update(Request $request, Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'final_price' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
        ]);

        $offer->update($request->only(['title', 'description', 'final_price', 'deadline']));

        return back()->with('success', 'Offer berhasil diperbarui.');
    }
}
