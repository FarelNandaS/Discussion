<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\post;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike($id) {
        $post = post::find($id);
        $user = Auth::user();
        $liked = $post->isLikedByUser();

        if ($liked) {
            $post->likes()->where('id_user', '=', $user->id)->delete();
            $liked = false;
        } else {
            $post->likes()->create(['id_user' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likeCount' => $post->likes->count()
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
    public function show(like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(like $like)
    {
        //
    }
}
