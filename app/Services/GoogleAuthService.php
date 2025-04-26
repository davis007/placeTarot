<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService
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
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(uniqid()), // Random password
                    'user_type' => 'client', // Default user type
                ]);
                
                // Create profile
                Profile::create([
                    'user_id' => $user->id,
                    'avatar' => $googleUser->avatar,
                ]);
                
                // Create points record
                Point::create([
                    'user_id' => $user->id,
                    'balance' => 0,
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
}
