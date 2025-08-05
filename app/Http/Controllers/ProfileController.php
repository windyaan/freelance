<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => $request->user()->profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
        $user = $request->user();
        $data = $request->validated();

    // Update User name/email
    $user->name = $data['name'];
    if ($user->email !== $data['email']) {
        $user->email = $data['email'];
        $user->email_verified_at = null; // reset verifikasi jika email berubah
    }
    $user->save();

    // Siapkan data untuk Profile
    $profileData = $request->only(['bio', 'avatar_url', 'skills']);

    // Jika bukan freelancer, jangan simpan skills
    if ($user->role !== 'freelancer') {
        unset($profileData['skills']);
    }

    // penggabungan
    if (isset($profileData['skills']) && is_string($profileData['skills'])) {
    $profileData['skills'] = array_map('trim', explode(',', $profileData['skills']));
}


    // Update profile
    $user->profile->update($profileData);

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    //show a freelancer's public profile
    //   public function show($freelancerId): View
    // {
    //     $freelancer = User::where('id', $freelancerId)
    //                     ->where('role', 'freelancer')
    //                     ->with('profile')
    //                     ->firstOrFail();

    //     return view('profile.show', [
    //         'freelancer' => $freelancer,
    //         'profile' => $freelancer->profile,
    //     ]);
    // }
}
