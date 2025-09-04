<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

// Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
//     $chat = Chat::find($chatId);

//     if (!$chat) {
//         return false; // kalau chat tidak ditemukan
//     }

//     //hanya client atau freelancer dari chat ini yg bisa join
//     return in_array($user->id, [$chat->client_id, $chat->freelancer_id]);
// });

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return Chat::where('id', $chatId)
            ->where(function ($q) use ($user) {
                $q->where('client_id', $user->id)
                  ->orWhere('freelancer_id', $user->id);
            })->exists();
});

// Channel notifikasi per user
Broadcast::channel('user.{userId}', function ($user, $userId) {
    // pastikan hanya user yg bersangkutan bisa listen channel ini
    return (int) $user->id === (int) $userId;
});

// Broadcast::channel('chat', function () {
// return true;
// });
