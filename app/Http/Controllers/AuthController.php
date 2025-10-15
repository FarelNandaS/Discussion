<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\userDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function handlerCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = user::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = user::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]);

                userDetail::create([
                    'user_id'=>$user->id
                ]);
                $user->refresh();
            }

            Auth::guard('web')->login($user);

            return redirect()->intended('/')->with('alert', [
                'type' => 'success',
                'message' => 'you have successfully logged in'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
