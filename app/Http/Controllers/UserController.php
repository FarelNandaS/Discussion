<?php

namespace App\Http\Controllers;

use App\Models\user;
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
        $validator = Validator::make($request->all(), [
            "email"=>"required|email",
            "password"=>"required|String",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $credential = $request->only('email', 'password');
        $remember = $request->has('remeber');

        if (Auth::attempt($credential, $remember)) {
            $user = user::where('email', '=', $request->email)->first();

            Auth::login($user, $request->filled('remember'));

            return redirect()->intended('/')->with('alert', [
                'type'=>'success',
                'message' => 'you have successfully logged in'
            ]);
        } else {
            return redirect()->back()->with('error','Email or password invalid');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"=>[
                "required",
                "string",
                "max:100",
                "unique:users",
                Rule::notIn(['login', 'register', 'post', 'logout']),
            ],
            "email"=>'required|email|unique:users',
            "password"=>"required|String|min:8|max:100",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        user::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect('/login')->with('alert', [
            'type'=> 'success',
            'message'=>'Your account has been successfully created'
        ]);
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
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username'=> 'required|string|max:100|unique:users,username,' . $user->id,
            'image'=>'nullable|file|mimes:jpg,jpeg,png,svg',
            'email'=> 'required|string|unique:users,email,' . $user->id,
            'bio'=>'nullable|string|max:255',
            'gender'=>'nullable|string|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        };

        if ($request->hasFile('image')) {
            if ($user->detail->image && $user->detail->image !== 'default.svg') {
                $oldImagePath = public_path('assets/profile/' . $user->detail->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }  
            }

            $file = $request->file('image');
            $fileName = time() . "." . $file->extension();
            $file->move(public_path("assets/profile"), $fileName);
            $user->detail->image = $fileName;
        };

        $user->username = $request->username;
        $user->email = $request->email;
        $user->detail->bio = $request->bio;
        $user->detail->gender = $request->gender;
        $user->detail->save();
        $user->save();

        return redirect()->route('profile', ['username'=>$user->username])->with('alert', [
            'type'=>'success',
            'message'=>'your profile has been successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('alert', [
            'type'=> 'success',
            'message'=>'You has been logout',
        ]);
    }

    public function giveAccess($id) {
        $user = User::find($id);

        $user->assignRole('Admin');
        $user->save();

        return redirect()->back()->with('alert', [
            'type'=>'success',
            'message'=>'successfully granted access',
        ]);
    }

    public function deleteAccess($id) {
        $user = User::find($id);

        $user->removeRole('Admin');
        $user->save();

                return redirect()->back()->with('alert', [
            'type'=>'success',
            'message'=>'successfully removed access',
        ]);
    }

    public function followUser(Request $request) {
        try {
            $user = user::findOrFail($request->id);
            $isFollowing = Auth::user()->isFollowing($user->id);

            if ($isFollowing) {
                Auth::user()->following()->detach($user->id);
            } else {
                Auth::user()->following()->attach($user->id);
            }

            $followers = $user->followers->count();
            $isFollowing = Auth::user()->isFollowing($user->id);

            return response()->json(array('status'=>'success', 'followers'=>$followers, 'isFollowing'=>$isFollowing));
        } catch (\Exception $e) {
            return response()->json(array('status'=>'error', 'message'=>$e->getMessage()));
        }
    }
}
