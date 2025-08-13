<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'content',
        'read_at'
    ];

    //relasi one to one ke tabel chat
    public function chat(){
        return $this->belongsTo(Chat::class,'chat_id');
    }

    // Relasi one to one ke tabel user (pengirim pesan)
    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
}
