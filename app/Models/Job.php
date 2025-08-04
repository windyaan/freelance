<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable =[
        'freelancer_id',
        'category_id',
        'title',
        'description',
        'starting_price',
        'is_active'
    ];
    //relasi many to one ke tabel user
     public function freelancer() {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    //relasi one to one ke tabel category
    public function category() {
        return $this->belongsTo(Category::class);
    }

    //relasi one to many ke tabel offer
    public function offers() {
    return $this->hasMany(Offer::class);
    }
}
