<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;

    //halaman freelancer:list job milik freelancer
    public function index()
    {
        $jobs = Job::where('freelancer_id', Auth::id())
        ->latest()
        ->get();
        return view('jobs.index', compact('jobs'));
    }

    //halaman client menampilkan semua job yg aktif
    public function clientIndex()
    {
    $jobs = Job::with(['freelancer.profile', 'category'])
        ->where('is_active', true)
        ->latest()
        ->get();

    return view('client.jobs.index', compact('jobs'));
    }

    //tambah job
    public function create()
    {
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }

    //menyimpan job baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $data['freelancer_id'] = Auth::id();

        Job::create($data);

        return redirect()->route('freelancer.services')->with('success', 'Job Berhasil Ditambahkan.');
    }

    // melihat detail job (untuk freelancer sendiri)
    // public function show(Job $job)
    // {
    //     $this->authorize('view', $job);
    //     return view('jobs.show', compact('job'));
    // }

    public function edit(Job $job)
    {
        $this->authorize('update', $job); // Optional: pakai policy
        $categories = Category::all();
        return view('jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job); // Optional

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $job->update($data);

        return redirect()->route('freelancer.services')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job); // Optional
        $job->delete();
        return redirect()->route('freelancer.service.destroy')->with('success', 'Job deleted.');
    }

    //BARU
    public function dashboardIndex()
{
    $jobs = Job::with(['freelancer.profile', 'category'])
        ->where('is_active', true)
        ->latest()
        ->get();

     return view('dashboard.client.index', compact('jobs'));
}


}
