<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
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
        $user = auth()->user();

        $validator = Validator::make(
            $request->all(), [
                "title"=> "required|String",
                "post"=> "required|String",
            ]
        );
        
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        post::create([
            'id_user'=>$user->id,
            'title'=>$request->title,
            'post'=>$request->post,
        ]);

        return redirect('/')->with('alert', [
            'type'=>'success',
            'message'=>'successfully created a post'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = post::find($request->id);

        if (auth()->id() != $post->id_user && auth()->user()->role != 'admin') {
            return abort(403);
        }

        $post->delete();

        return redirect('/')->with('alert', [
            'type'=>'success',
            'message'=>'successfully deleted the post'
        ]);
    }

    public function savePost(Request $request) {
        try {
            $user = Auth::user();
            $post = post::findOrFail($request->id);

            if ($post->isSavedByUser()) {
                $post->saves()->where('id_user', $user->id)->delete();
            } else {
                $post->saves()->create(['id_user'=>$user->id]);
            }

            return response()->json(array('status'=>'success', 'message'=>'success to save the post', 'saved'=>$post->isSavedByUser()));
        } catch (\Exception $e) {
            return response()->json(array('status'=>'error', 'message'=>$e->getMessage()));
        }
    }

    public function likePost(Request $request) {
        try {
            $user = Auth::user();
            $post = post::findOrFail($request->id);

            if ($post->isLikedByUser()) {
                $post->likes()->where('id_user', $user->id)->delete();
            } else {
                $post->likes()->create(['id_user'=>$user->id]);
            }

            return response()->json(array('status'=>'success', 'message'=>'success to like the post', 'liked'=>$post->isLikedByUser(), 'count'=>$post->likes->count()));
        } catch (\Exception $e) {
            return response()->json(array('status'=>'error', 'message'=>$e->getMessage()));
        }
    }
}