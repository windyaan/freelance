<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

    if (!$chat) {
        return false; // kalau chat tidak ditemukan
    }

    //hanya client atau freelancer dari chat ini yg bisa join
    return in_array($user->id, [$chat->client_id, $chat->freelancer_id]);
});

