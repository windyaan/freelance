<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show($id)
    {
        // Ambil user beserta profile dan jobs-nya
        $user = User::with(['profile', 'jobs.category'])->findOrFail($id);

        // Jika user belum punya profile, buat profile kosong
        if (!$user->profile) {
            $user->profile = new Profile([
                'bio' => '',
                'skills' => [],
                'avatar_url' => null
            ]);
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing current user's profile.
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load(['profile', 'jobs.category']);

        // Jika user belum punya profile, buat profile kosong
        if (!$user->profile) {
            $user->profile = new Profile([
                'bio' => '',
                'skills' => [],
                'avatar_url' => null
            ]);
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Show the form for editing specified user's profile (dengan ID).
     */
    public function editWithId($id)
    {
        $user = User::with(['profile', 'jobs.category'])->findOrFail($id);

        // Pastikan user hanya bisa edit profile sendiri (kecuali admin)
        if (Auth::id() !== (int)$id && !$this->isCurrentUserAdmin()) {
            abort(403, 'Unauthorized to edit this profile.');
        }

        // Jika user belum punya profile, buat profile kosong
        if (!$user->profile) {
            $user->profile = new Profile([
                'bio' => '',
                'skills' => [],
                'avatar_url' => null
            ]);
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update current user's profile.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:1000',
            'avatar_url' => 'nullable|url|max:255',
            // 'achievement' => 'nullable|string|max:1000'
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update atau create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $request->bio,
                'skills' => $request->skills,
                'avatar_url' => $request->avatar_url,
                'achievement' => $request->achievement
            ]
        );

        return redirect()->route('profile.edit')
                        ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update specified user's profile (dengan ID).
     */
    public function updateWithId(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Pastikan user hanya bisa edit profile sendiri (kecuali admin)
        if (Auth::id() !== (int)$id && !$this->isCurrentUserAdmin()) {
            abort(403, 'Unauthorized to edit this profile.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:1000',
            'avatar_url' => 'nullable|url|max:255',
            'achievement' => 'nullable|string|max:1000'
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update atau create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $request->bio,
                'skills' => $request->skills,
                'avatar_url' => $request->avatar_url,
                'achievement' => $request->achievement
            ]
        );

        return redirect()->route('profile.show', $user->id)
                        ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete current user's profile.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Check if current authenticated user is admin
     *
     * @return bool
     */
    private function isCurrentUserAdmin()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // Option 1: Check by role field (uncomment if you have 'role' column in users table)
        // return $user->role === 'admin';

        // Option 2: Check by specific admin emails
        $adminEmails = [
            'admin@freelance.com',
            'superadmin@freelance.com',
            // Add more admin emails as needed
        ];
        return in_array($user->email, $adminEmails);

        // Option 3: Check by user_type field (uncomment if you have 'user_type' column)
        // return $user->user_type === 'admin';

        // Option 4: Check by is_admin boolean field (uncomment if you have 'is_admin' column)
        // return $user->is_admin === true;
    }
}
