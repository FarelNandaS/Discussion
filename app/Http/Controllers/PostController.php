<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        try {
            $user = auth()->user();
    
            $validator = Validator::make(
                $request->all(), [
                    "title"=> "required|String",
                    "post"=> "required|String",
                ]
            );
            
            if ($validator->fails()) {
                return redirect()->back()->with('alert', ['type'=>'error', 'message'=>$validator->errors()->first()]);
            }
    
            // dd($request);
    
            Post::create([
                'id_user'=>$user->id,
                'title'=>$request->title,
                'content'=>$request->post,
            ]);
    
            return redirect('/')->with('alert', [
                'type'=>'success',
                'message'=>'successfully created a post'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type'=>'error', 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $post = Post::findOrFail($request->id);
            $post->update([
                'title'=>$request->title,
                'content'=>$request->post,
            ]);

            return redirect()->route('detail-post', ['id'=>$request->id])->with('alert', ['type'=>'success', 'message'=>'successfully update post']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type'=>'error', 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->id);

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
            $post = Post::findOrFail($request->id);

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
}