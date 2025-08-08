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
    public function index()
    {
        // Hitung jumlah user berdasarkan role
        $users = User::all(); // Ambil semua data user
        $totalClients = User::where('role', 'client')->count();
        $totalFreelancers = User::where('role', 'freelancer')->count();

        // Hitung jumlah order
        $totalOrders = Order::count();

        // Kirim data ke view
        return view('dashboard.admin.index', compact('totalClients', 'totalFreelancers', 'totalOrders','users'));
    }
}
