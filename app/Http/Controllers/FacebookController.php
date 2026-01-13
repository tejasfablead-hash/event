<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Request;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['email'])
            ->redirect();
    }

   public function handleFacebookCallback(Request $request)
{
    try {
        $facebookUser = Socialite::driver('facebook')
        ->stateless()
        ->user(); 

        $email = $facebookUser->getEmail() ?? $facebookUser->getId() . '@facebook.com';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name'        => $facebookUser->getName(),
                'email'       => $email,
                'facebook_id' => $facebookUser->getId(),
                'password'    => bcrypt(Str::random(16)),
            ]);
        } else {
            $user->update([
                'facebook_id' => $facebookUser->getId(),
            ]);
        }

        Auth::login($user, true); // true = remember session

        return redirect()->route('DashboardPage');

    } catch (\Exception $e) {
        // \Log::error('Facebook Login Error: ' . $e->getMessage()); // log the error
        return redirect()->route('LoginPage')
            ->with('error', 'Facebook login failed. Please check logs.');
    }
}

}
