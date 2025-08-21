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
        // $this->middleware('auth'); // pastikan user sudah login
    }

    /**
     * List semua chat yang melibatkan user login
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $chats = Chat::where('client_id', $userId)
                    ->orWhere('freelancer_id', $userId)
                    ->with(['client', 'freelancer', 'messages' => function ($q) {
                        $q->latest()->limit(1);
                    }])
                    ->orderBy('updated_at', 'desc')
                    ->get();

                    // ambil parameter chat_id dari query string jika ada
    //     $chatId = $request->get('chat_id');
    //     // tentukan chat aktif
    // $activeChat = $chatId
    //     ? $chats->where('id', $chatId)->first()
    //     : $chats->first();

     $chatId = $request->get('chat_id');
    $activeChat = $chatId
        ? Chat::with(['messages.sender'])  // ✅ chat aktif ambil semua pesan + sender
            ->find($chatId)
        : ($chats->first()
            ? Chat::with(['messages.sender'])->find($chats->first()->id)
            : null);

      return view('chat.index', compact('chats','activeChat'));
    }

    /**
     * Tampilkan chat lengkap beserta semua
     * menandai pesan lawan sebagai dibaca dan broadcast messageread
     */
    public function show(Chat $chat)
    {
        $this->authorize('view', $chat); // cek policy apakah user boleh akses chat ini

        // Ambil semua pesan dari lawan yang belum dibaca
        // $unreadMessages = $chat->messages()
        //     ->where('sender_id', '!=', Auth::id())
        //     ->whereNull('read_at')
        //     ->get();

        // foreach ($unreadMessages as $msg) {
        //     $msg->update(['read_at' => now()]);

        //     // Broadcast event read agar centang berubah di sisi pengirim
        //     broadcast(new MessageRead($msg))->toOthers();
        // }

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

        // Broadcast ke channel private chat.{chat_id}
        broadcast(new MessageSent($message))->toOthers();

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    /*** Tandai 1 pesan sebagai sudah dibaca*/
    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message->chat);

        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
            // broadcast(event: new MessageRead($message))->toOthers();
        }

        return back();
    }
}
