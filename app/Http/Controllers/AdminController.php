<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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
    // $users = User::all();

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

    // Total profit dari amount
    $totalProfit = Order::where('status', 'paid')->sum('amount');

    return view('dashboard.admin.index', compact('totalClients', 'totalFreelancers', 'totalOrders','totalProfit', 'users', 'search'));
}

 public function exportUsersProfitPdf()
    {
        $users = User::all();
    // Order yang sudah lunas
    $paidOrders = Order::where('status', 'paid')->get();

    // Order yang belum lunas (masih DP)
    $unpaidOrders = Order::where('status', 'dp')->get();

    // Hitung total profit
    $totalProfit = $paidOrders->sum('amount');

        $pdf = Pdf::loadView('dashboard.admin.users-profit-pdf', compact('users', 'paidOrders','unpaidOrders','totalProfit'));
        return $pdf->download('profit_report.pdf');
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
