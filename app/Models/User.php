<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'client', 'freelancer', 'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke Profile one to one
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relasi ke job one to many
    public function jobs()
    {
        return $this->hasMany(Job::class, 'freelancer_id');
    }

    //Relasi ke offer one to many
    public function offers()
    {
        return $this->hasMany(Offer::class, 'client_id');
    }

    public function clientChats()
    {
        return $this->hasMany(Chat::class, 'client_id');
    }

    public function freelancerChats()
    {
        return $this->hasMany(Chat::class, 'freelancer_id');
    }

    //relasi ke chat one to many
    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    //relasi one to many ke tabel notification
    public function notifications()
    {
    return $this->hasMany(Notification::class, 'user_id');
    }

    // Tambahkan method ini di dalam class User
public function profiles()
{
    return $this->hasOne(Profile::class);
}

    // // Role check helper
    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    // public function isClient()
    // {
    //     return $this->role === 'client';
    // }

    // public function isFreelancer()
    // {
    //     return $this->role === 'freelancer';
    // }

}
