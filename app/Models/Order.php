<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'amount',
        'amount_paid',
        'payment_method',
        'status',
    ];

    //relasi many to one ke tabe offer
    public function offer() {
        return $this->belongsTo(Offer::class);
    }
}
