<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm() {
        return view('pages.auth.forgotPassword');
    }

    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email'=>'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT 
            ? redirect()->route('login')->with('alert', ['type'=>'success', 'message'=>'Success to send you reset link, please check your email'])
            : back()->withErrors(['email'=>[__($status)]])->withInput();
    }

    public function resetPassword(Request $request, $token = null) {
        return view('pages.auth.resetPassword', ['token'=>$token, 'email'=>$request->email]);
    }

    public function resetPasswordAttempt(Request $request) {
        $request->validate([
            'token'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:8|confirmed'
        ]);

        $status = Password::reset($request->only('email', 'token', 'password', 'password_confirmation'), function ($user, $password) {
            $user->forceFill([
                'password'=>Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('alert', ['type'=>'success', 'message'=>'Your password has been reset successfully'])
            : back()->withErrors(['email'=>[__($status)]]);
    }
}
