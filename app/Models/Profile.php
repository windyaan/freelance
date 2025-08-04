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
        'skills'=>'array',// untuk freelancer berupa json
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    //relasi one to one ke table user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
