<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::firstOrCreate(
                ['facebook_id' => $facebookUser->id],
                [
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email ?? $facebookUser->id.'@facebook.com',
                    'password' => bcrypt('password')
                ]
            );

            Auth::login($user);

            return redirect()->route('DashboardPage');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Facebook login failed!');
        }
    }
}
