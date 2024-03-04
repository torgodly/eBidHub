<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function deleteAvatar(Request $request): RedirectResponse
    {
        $request->user()->avatar_url = null;
        $request->user()->save();

        return back()->with('status', 'avatar-deleted');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar_url')) {
            $avatar = $request->file('avatar_url');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/', $filename);
            $request->user()->avatar_url = $filename;
        }
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
        // Check if the user has any relations that prevent account deletion
        if ($user->auctions()->exists() || $user->bids()->exists()) {
            return back()->withErrors(['relations' => __('You cannot delete your account because you have active auctions or bids.')]);
        }
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
