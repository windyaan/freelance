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

    public function index()
    {
        $jobs = Job::where('freelancer_id', Auth::id())->get();
        return view('jobs.index', compact('jobs'));
    }

    public function clientIndex()
    {
    $jobs = Job::with(['freelancer.profile', 'category'])
        ->where('is_active', true)
        ->latest()
        ->get();

    return view('client.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
        ]);

        $data['freelancer_id'] = Auth::id();

        Job::create($data);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $job->update($data);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job); // Optional
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted.');
    }
}
