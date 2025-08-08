<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'title',
        'description',
        'status',
        'completed_at'//optional
    ];

    //relasi one to one ke tabel offers
    public function offer() {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
