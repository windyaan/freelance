<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    //halaman admin untuk melihat laporan
    public function index()
    {
        $reports = Report::with(['client', 'freelancer'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with(['client', 'freelancer'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function banFreelancer($id)
    {
        $report = Report::findOrFail($id);

        $freelancer = $report->freelancer;
        $freelancer->is_active = false; // Nonaktifkan freelancer
        $freelancer->save();

        return back()->with('success', 'Freelancer telah dinonaktifkan.');
    }
}
