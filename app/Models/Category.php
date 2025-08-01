<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
 use HasFactory;

    protected $fillable = [
        'name'
    ];

    //relasinya one to many ke tabel jobs
    public function jobs() {
        return $this->hasMany(Job::class);
    }
}
