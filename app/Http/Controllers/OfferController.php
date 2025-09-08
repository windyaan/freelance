<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Job;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index()
    {
        $offers = Offer::where('freelancer_id', Auth::id())
            ->with('client', 'job')
            ->get();

        return view('chat.index', compact('offers'));
    }


    // public function create(Request $request)
    // {
    //     // Ambil semua job milik freelancer yang sedang login
    //     $availableJobs = Job::where('freelancer_id', Auth::id())->get();

    //     // Asumsi client_id dapat dikirim melalui parameter URL dari halaman chat/profil klien
    //     $clientId = $request->query('client_id');

    //     return view('offers.create', compact('availableJobs', 'clientId'));
    // }


    public function store(Request $request)
    {
        $request->validate([
            'job_id'       => 'required|exists:jobs,id',
            // 'client_id'    => 'required|exists:users,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'final_price'  => 'required|numeric|min:0',
            'deadline'     => 'required|date|after:today',
        ]);

        // Pastikan job yang dipilih memang milik freelancer yang sedang login
        $job = Job::where('id', $request->job_id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        // Buat penawaran baru
       $offer = Offer::create([
            'job_id'        => $job->id,
            'freelancer_id' => Auth::id(), // ID freelancer yang sedang login
            'client_id'     => $request->client_id, // ID klien yang diterima dari form
            'title'         => $request->title,
            'description'   => $request->description,
            'final_price'   => $request->final_price,
            'deadline'      => $request->deadline,
            'status'        => 'pending',
        ]);

        // Cari atau buat chat room antara client dan freelancer
        $chat = Chat::firstOrCreate([
            'client_id'     => $request->client_id,
            'freelancer_id' => Auth::id(),
        ], [
            'offer_id'      => $offer->id, // Set offer_id hanya saat membuat chat baru
        ]);

        // Buat message yang mereferensikan offer ini
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->client_id,
            'content'     => 'Penawaran baru telah dibuat', // Berikan nilai content yang valid
            'offer_id'    => $offer->id,
            'chat_id'     => $chat->id, // Sekarang ada chat_id yang valid
        ]);

        // return redirect()->route('chat.index')->with('success', 'Offer berhasil dibuat.');
        return response()->json(['success' => true, 'message' => 'Penawaran berhasil dibuat.']);
    }



    public function edit(Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) {
            abort(403); // Akses ditolak jika bukan pemilik offer
        }

        return view('offers.edit', compact('offer'));
    }


    public function update(Request $request, Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'final_price'  => 'required|numeric|min:0',
            'deadline'     => 'required|date|after:today',
        ]);

        $offer->update($request->only(['title', 'description', 'final_price', 'deadline']));

        return back()->with('success', 'Offer berhasil diperbarui.');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->freelancer_id !== Auth::id()) {
            abort(403);
        }

        $offer->delete();

        return back()->with('success', 'Offer berhasil dihapus.');
    }
}