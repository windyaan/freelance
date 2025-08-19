<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //ini report controller untuk client
    // Form kirim laporan
    public function create()
    {
        return view('client.reports.create');
    }

    // Simpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Report::create([
            'client_id' => Auth::id(),
            'freelancer_id' => $request->freelancer_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim, menunggu review admin.');
    }
}
