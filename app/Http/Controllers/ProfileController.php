<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('profile.show', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = Profile::create([
                'user_id' => $user->id,
            ]);
        }

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = Profile::create([
                'user_id' => $user->id,
            ]);
        }

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($profile->avatar) {
                Storage::delete('public/avatars/' . $profile->avatar);
            }

            // Store new avatar
            $avatarName = $user->id . '_' . time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $avatarName);

            $profile->avatar = $avatarName;
        }

        // Update profile fields
        $profile->bio = $request->bio;
        $profile->specialties = $request->specialties;
        $profile->response_time = $request->response_time;
        $profile->is_available = $request->boolean('is_available');
        $profile->save();

        return redirect()->route('profile.edit')
            ->with('success', 'プロフィールが更新されました。');
    }
}
