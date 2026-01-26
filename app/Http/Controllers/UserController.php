<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credential = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credential, $remember)) {
            $user = Auth::user();

            if ($user->hasVerifiedEmail()) {
                $redirectTo = $user->hasRole('Admin') ? '/admin' : '/';

                return redirect()->intended($redirectTo)->with('alert', ['type' => 'success', 'message' => 'you have successfully logged in']);
            } else {
                return redirect()->route('verification.notice');
            }
        } else {
            return redirect()->back()->withErrors(['email' => 'Email or password invalid'])->withInput($request->only('email'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => [
                "required",
                "string",
                "max:100",
                "unique:users",
                Rule::notIn(['login', 'register', 'post', 'logout']),
            ],
            "email" => 'required|email|unique:users',
            "password" => "required|String|min:8|max:100",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();

        Auth::login($user);

        // return redirect('/login')->with('alert', [
        //     'type' => 'success',
        //     'message' => 'Your account has been successfully created'
        // ]);

        return redirect()->route('verification.notice');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg',
            'email' => 'required|string|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }
        ;

        if ($request->hasFile('image')) {
            if ($user->detail->image && $user->detail->image !== 'default.svg') {
                $oldImagePath = public_path('storage/profile/' . $user->detail->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('image');
            // $fileNameOG = pathinfo()
            $fileName = $file->getFilename() . time() . "." . $file->extension();
            $file->move(public_path("storage/profile"), $fileName);
            $user->detail->image = $fileName;
        } else if ($request->remove_image == '1') {
            if ($user->detail->image && $user->detail->image !== 'default.svg') {
                $oldImagePath = public_path('storage/profile/' . $user->detail->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $user->detail->image = null;
        }
        ;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->detail->bio = $request->bio;
        $user->detail->gender = $request->gender;
        $user->detail->save();
        $user->save();

        return redirect()->route('profile', ['username' => $user->username])->with('alert', [
            'type' => 'success',
            'message' => 'your profile has been successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('alert', [
            'type' => 'success',
            'message' => 'You has been logout',
        ]);
    }

    public function giveAccess($id)
    {
        $user = User::find($id);

        $user->assignRole('Admin');
        $user->save();

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'successfully granted access',
        ]);
    }

    public function deleteAccess($id)
    {
        $user = User::find($id);

        $user->removeRole('Admin');
        $user->save();

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'successfully removed access',
        ]);
    }
}
