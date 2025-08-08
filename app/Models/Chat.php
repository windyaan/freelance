<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'client_id',
        'freelancer_id',
        'offer_id', //nullable
    ];

    //relasi one to many ke tabel message
    public function messages(){
        return $this->hasMany(Message::class,'chat_id');
    }

    //relasi one to one ke tabel user
    public function client(){
        return $this->belongsTo(User::class,'client_id');
    }

    public function freelancer(){
        return $this->belongsTo(User::class,'freelancer_id');
    }

}
