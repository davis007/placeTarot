<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if (!$user) {
                // New user - redirect to user type selection
                return view('auth.select_user_type', [
                    'googleId' => $googleUser->id,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'avatar' => $googleUser->avatar,
                ]);
            } else if (!$user->google_id) {
                // Update existing user with Google ID
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            }

            // Login
            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google認証に失敗しました。もう一度お試しください。');
        }
    }

    /**
     * Save user type after Google authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectUserType(Request $request)
    {
        $request->validate([
            'google_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'avatar' => 'nullable|string',
            'user_type' => 'required|string|in:client,practitioner',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'password' => bcrypt(uniqid()), // Random password
            'user_type' => $request->user_type,
        ]);

        // Create profile
        Profile::create([
            'user_id' => $user->id,
            'avatar' => $request->avatar,
            'bio' => '',
            'specialties' => json_encode([]),
            'is_available' => true,
        ]);

        // Create points record
        Point::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        // Login
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
