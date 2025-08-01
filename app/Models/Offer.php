<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'freelancer_id',
        'job_id',
        'title',
        'description',
        'final_price',
        'deadline',
        'status'
    ];

    //relasi many to one ke tabel user
    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    //relasi many to one ke tabel user
    public function freelancer() {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    //relasi one to many ke tabel milestone
    public function milestones() {
        return $this->hasMany(Milestone::class, 'offer_id');
    }

    //relasi one to many ke tabel order
    public function orders() {
    return $this->hasMany(Order::class, 'offer_id');
    }

    //relasi many to one ke tabel job
    public function job() {
    return $this->belongsTo(Job::class);
    }
}
