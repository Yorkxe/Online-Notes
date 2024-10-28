<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Profiles;

class GoogleLoginController extends Controller
{
    public function RedirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function HandleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => \Hash::make(rand(100000,999999))]);
        }
        // dd($user);
        Auth::login($user);
        
        return redirect()->route('Profile.show', ['user' => $user]);
        }
}
