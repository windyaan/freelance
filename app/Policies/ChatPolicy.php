<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;

class ChatPolicy
{
    //akses membaca chat dan pesan
    public function view(User $user, Chat $chat)
    {
        return $chat->client_id === $user->id || $chat->freelancer_id === $user->id;
    }

    //mengirim pesan
    public function sendMessage(User $user, Chat $chat)
    {
        return $chat->client_id === $user->id || $chat->freelancer_id === $user->id;
    }
}
