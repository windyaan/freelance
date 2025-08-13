<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
   public function index(Request $request)
{
    // Ambil input pencarian dari query string ?search=...
    $search = $request->input('search');

    // Query user, kalau ada pencarian filter berdasarkan nama
    $usersQuery = User::query();

    if ($search) {
        $usersQuery->where('name', 'like', '%' . $search . '%');
    }

    // Ambil data user setelah filter
    $users = $usersQuery->get();

    // Hitung jumlah user berdasarkan role, tetap semua tanpa filter pencarian
    $totalClients = User::where('role', 'client')->count();
    $totalFreelancers = User::where('role', 'freelancer')->count();

    // Hitung jumlah order
    $totalOrders = Order::count();

    return view('dashboard.admin.index', compact('totalClients', 'totalFreelancers', 'totalOrders', 'users', 'search'));
}

/**
    * Handle search request from navbar
    */
   public function search(Request $request)
   {
       $query = $request->get('q', '');
       
       if (empty($query)) {
           return redirect()->route('admin.dashboard');
       }
       
       // Redirect ke admin dashboard dengan parameter search
       return redirect()->route('admin.dashboard', ['search' => $query]);
   }
}