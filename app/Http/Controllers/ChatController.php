<?php

namespace App\Http\Controllers;

use App\Events\Example;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Offer;
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
                    ->with(['client.profile', 'freelancer.profile', 'messages' => function ($q) {
                        $q->latest()->limit(1);
                    }])
                    ->orderBy('updated_at', 'desc')
                    ->get();

        // Ambil semua job milik freelancer login
        $availableJobs = Job::where('freelancer_id', $userId)->get();

        // Ambil chat aktif berdasarkan parameter
        $chatId = $request->get('chat_id');
        $activeChat = null;
        
        if ($chatId) {
            $activeChat = Chat::with([
                'messages.sender.profile',
                'client.profile',
                'freelancer.profile'
            ])->find($chatId);
        } elseif ($chats->first()) {
            $activeChat = Chat::with([
                'messages.sender.profile', 
                'client.profile',
                'freelancer.profile'
            ])->find($chats->first()->id);
        }

        return view('chat.index', compact('chats', 'activeChat', 'availableJobs'));
    }

    /**
     * Tampilkan chat lengkap beserta semua pesan dan offers
     */
    public function show(Chat $chat)
    {
        $messages = $chat->messages()
                         ->with('sender.profile')
                         ->orderBy('created_at')
                         ->get();

        // Ambil semua offers antara client dan freelancer ini
        $offers = Offer::where(function($query) use ($chat) {
                    $query->where('client_id', $chat->client_id)
                          ->where('freelancer_id', $chat->freelancer_id);
                })
                ->orWhere(function($query) use ($chat) {
                    $query->where('client_id', $chat->freelancer_id)
                          ->where('freelancer_id', $chat->client_id);
                })
                ->with(['job', 'freelancer.profile', 'client.profile'])
                ->orderBy('created_at')
                ->get();

        $job = $chat->job;
        
        // Tentukan lawan chat (bukan user login)
        $user = Auth::id() == $chat->client_id ? $chat->freelancer : $chat->client;

        return view('chat.show', compact('chat', 'messages', 'offers', 'user', 'job'));
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
            'job_id' => 'required|exists:jobs,id',
        ]);

        $chat = Chat::firstOrCreate([
            'client_id' => $request->client_id,
            'freelancer_id' => $request->freelancer_id,
        ], [
            'offer_id' => $request->offer_id,
            'job_id' => $request->job_id,
        ]);

        return redirect()->route('chat.show', $chat);
    }

    /**
     * Kirim pesan baru dalam chat (dengan realtime via Reverb)
     */
    public function storeMessage(Request $request, Chat $chat)
    {
        // $this->authorize('sendMessage', $chat);

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // Tentukan receiver_id
        $receiverId = ($chat->client_id === Auth::id()) 
                     ? $chat->freelancer_id 
                     : $chat->client_id;

        // Simpan pesan ke database
        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId, // Tambahkan ini jika kolom ada
            'content' => $request->input('content'),
        ]);

        // Update timestamp chat
        $chat->touch();

        // Broadcast ke channel private chat.{chat_id}
        broadcast(new MessageSent($message))->toOthers();

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    /**
     * Kirim pesan via AJAX (realtime)
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        // $this->authorize('sendMessage', $chat);

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // Tentukan penerima (lawan chat)
        $receiverId = $chat->client_id == Auth::id()
            ? $chat->freelancer_id
            : $chat->client_id;

        // Simpan pesan
        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId, // Tambahkan jika kolom ada
            'content' => $request->input('content'),
        ]);

        // Update timestamp chat
        $chat->touch();

        // Broadcast ke channel chat.{id}
        broadcast(new MessageSent($message))->toOthers();

        // Simpan notifikasi di DB
        $notification = Notification::create([
            'user_id' => $receiverId,
            'type' => 'message',
            'content' => Auth::user()->name . ' mengirim pesan baru',
            'link_url' => route('chat.show', $chat->id),
        ]);

        // Broadcast ke notification
        broadcast(new NotificationSent($notification));

        // Return JSON supaya bisa ditangani JS di frontend
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'chat_id' => $message->chat_id,
                'sender_id' => $message->sender_id,
                'content' => $message->content,
                'created_at' => $message->created_at->toISOString(),
            ]
        ]);
    }

    public function markAsRead(Message $message)
    {
        // $this->authorize('view', $message->chat);

        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return back();
    }
}