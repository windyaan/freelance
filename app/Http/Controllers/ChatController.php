<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;


class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // pastikan user sudah login
    }

    /**
     * List semua chat yang melibatkan user login
     */
    public function index()
    {
        $userId = Auth::id();

        $chats = Chat::where('client_id', $userId)
                    ->orWhere('freelancer_id', $userId)
                    ->with(['client', 'freelancer', 'messages' => function ($q) {
                        $q->latest()->limit(1);
                    }])
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return view('dashboard.client.chat', compact('chats'));
    }

    /**
     * Tampilkan chat lengkap beserta semua pesan
     */
    public function show(Chat $chat)
    {
        $this->authorize('view', $chat); // cek policy apakah user boleh akses chat ini

        $messages = $chat->messages()
                         ->with('sender')
                         ->orderBy('created_at')
                         ->get();

        return view('chat.show', compact('chat', 'messages'));
    }

    /**
     * Buat chat baru (atau ambil jika sudah ada)
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'freelancer_id' => 'required|exists:users,id',
            'offer_id' => 'nullable|exists:offers,id',
        ]);

        $chat = Chat::firstOrCreate([
            'client_id' => $request->client_id,
            'freelancer_id' => $request->freelancer_id,
        ], [
            'offer_id' => $request->offer_id,
        ]);

        return redirect()->route('chat.show', $chat);
    }

    /**
     * Kirim pesan baru dalam chat (dengan realtime via Reverb)
     */
    public function storeMessage(Request $request, Chat $chat)
    {
        $this->authorize('sendMessage', $chat);

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // Simpan pesan ke database
        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        // Broadcast event menggunakan Laravel Event
        event(new MessageSent($message));

        // Kirim ke Reverb untuk realtime
        // Channel: chat.{chat_id} agar semua peserta chat menerima
        app('reverb')->sendToChannel('chat.' . $chat->id, [
        'message' => $message->content,
        'sender_id' => $message->sender_id,
        'chat_id' => $chat->id,
        'created_at' => $message->created_at->toDateTimeString(),
        ]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    /*** Tandai pesan sebagai sudah dibaca*/
    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message->chat);

        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return back();
    }
}
