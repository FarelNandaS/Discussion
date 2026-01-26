<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice() {
        return auth()->user()->hasVerifiedEmail() ? redirect()->route('home') : view('pages.auth.verificationNotice');
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('home')->with('alert', ['type'=>'success', 'message'=>'Your email verified!']);
    }

    public function resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('alert', ['type'=>'success', 'message'=>'Verification link send!']);
    }

    public function changeEmail(Request $request) {
        $request->validate([
            'email'=>'required|email|unique:users,email'
        ]);

        $user = auth()->user();
        $user->update([
            'email'=>$request->email,
            'email_verified_at'=>null
        ]);

        $user->sendEmailVerificationNotification();

        return back()->with('alert', ['type'=>'success', 'message'=>'Email updated and new link sent!']);
    }
}
