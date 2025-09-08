<?php

namespace App\Http\Controllers;

use App\Events\Example;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\NotificationSent;
use App\Models\Job;


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

                    // ambil semua job milik freelancer login
    $availableJobs = Job::where('freelancer_id', $userId)->get();

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

      return view('chat.index', compact('chats','activeChat','availableJobs'));
    }

    /**
     * Tampilkan chat lengkap beserta semua
     * menandai pesan lawan sebagai dibaca dan broadcast messageread
     */
    public function show(Chat $chat)
    {
        // $this->authorize('view', $chat); // cek policy apakah user boleh akses chat ini

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

        $job = $chat->job;
         // Tentukan lawan chat (bukan user login)
        $user = Auth::id() == $chat->client_id ? $chat->freelancer : $chat->client;

        return view('chat.show', compact('chat', 'messages','user','job'));
    }


//     public function openWithFreelancer($freelancerId, Request $request)
// {
//     $chat = Chat::firstOrCreate([
//         'client_id'     => Auth::id(),
//         'freelancer_id' => $freelancerId,
//     ], [
//         'job_id' => $request->job_id, // kalau perlu job
//     ]);

//     return redirect()->route('chat.show', $chat->id);
// }


    /**
     * Buat chat baru (atau ambil jika sudah ada)
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'freelancer_id' => 'required|exists:users,id',
            'offer_id' => 'nullable|exists:offers,id',
            'job_id'        => 'required|exists:jobs,id',
        ]);

        $chat = Chat::firstOrCreate([
            'client_id' => $request->client_id,
            'freelancer_id' => $request->freelancer_id,
        ], [
            'offer_id' => $request->offer_id,
            'job_id'   => $request->job_id,
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

        // event(new Example("asjhdasdkas"));

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    /**
 * Kirim pesan via AJAX (realtime)
 */
public function sendMessage(Request $request, Chat $chat)
{
    $this->authorize('sendMessage', $chat);

    $request->validate([
        'content' => 'required|string|max:2000',
    ]);

    // Simpan pesan
    $message = Message::create([
        'chat_id'   => $chat->id,
        'sender_id' => Auth::id(),
        'content'   => $request->input('content'),
    ]);

    // Broadcast ke channel chat.{id}
    broadcast(new MessageSent($message))->toOthers();

    // Tentukan penerima (lawan chat)
    $receiverId = $chat->client_id == Auth::id()
        ? $chat->freelancer_id
        : $chat->client_id;

   // Simpan notifikasi di DB
    $notification = Notification::create([
        'user_id' => $receiverId,
        'type'    => 'message',
        'content' => Auth::user()->name . ' mengirim pesan baru',
        'link_url'=> route('chat.show', $chat->id),
    ]);

    //broadcast ke notification
    broadcast(new NotificationSent($notification));

    // ✅ return JSON supaya bisa ditangani JS di frontend
    return response()->json([
        'success' => true,
        'message' => [
            'id'        => $message->id,
            'chat_id'   => $message->chat_id,
            'sender_id' => $message->sender_id,
            'content'   => $message->content,
            'created_at'=> $message->created_at->toISOString(),
        ]
    ]);
}

    //ini lebih membaca seluruh ruangan chat
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
