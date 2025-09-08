<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'job_id',
        'client_id',
        'freelancer_id',
        'offer_id', // nullable
    ];

    // Relasi one to many ke tabel message
    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    // Relasi one to one ke tabel user
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Relasi ke offer (nullable)
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Method untuk mendapatkan semua offers antara client dan freelancer
    public function getAllOffers()
    {
        return Offer::where(function($query) {
                    $query->where('client_id', $this->client_id)
                          ->where('freelancer_id', $this->freelancer_id);
                })
                ->orWhere(function($query) {
                    $query->where('client_id', $this->freelancer_id)
                          ->where('freelancer_id', $this->client_id);
                })
                ->with(['job', 'freelancer.profile', 'client.profile'])
                ->orderBy('created_at')
                ->get();
    }

    // Accessor untuk mendapatkan offers
    public function getOffersAttribute()
    {
        return $this->getAllOffers();
    }
}