<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'bio',
        'avatar_url',
        'skills', // Field skills (akan disimpan sebagai JSON di database)
    ];

    /**
     * Cast attributes ke tipe data tertentu
     * skills akan otomatis di-convert dari JSON ke array saat diambil
     * dan dari array ke JSON saat disimpan
     */
    protected $casts = [
        'skills' => 'array',
    ];

    /**
     * Relasi one to one ke table users
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}