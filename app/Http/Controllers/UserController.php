<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $jobs = Job::with(['freelancer.profile', 'category'])
        // ->where('is_active', true)
        // ->latest()
        // ->get();

        return view('dashboard.client.index');
    }
}
