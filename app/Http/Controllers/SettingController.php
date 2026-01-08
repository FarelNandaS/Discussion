<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function changePassword(Request $request) {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('alert', ['type'=>'success', 'message'=>'success to change password']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type'=>'error', 'message'=>$e->getMessage()]);
        }
    }

    public function checkPassword(Request $request) {
        try {
            $valid = Hash::check($request->password, auth()->user()->password);

            return response()->json([
                'status'=>'success',
                'valid'=>$valid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
