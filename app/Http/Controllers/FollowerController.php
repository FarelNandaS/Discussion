<?php

namespace App\Http\Controllers;

use App\Models\follower;
use App\Models\user;
use Auth;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function toggleFollow($id)
    {
        $user = user::find($id); //yang di follow
        $userFollow = Auth::user(); //yang memfollow
        $followed = $user->isFollowedByUser();
        
        if ($followed) {
            $userFollow->following()->detach($user->id);
            $followed = false;
        } else {
            $userFollow->following()->attach($user->id);
            $followed = true;
        }

        return response()->json([
            'followed' => $followed,
            'countFollowers' => $user->followers()->count(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(follower $follower)
    {
        //
    }
}
