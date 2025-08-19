<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
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
    public function destroy($id)
    {
        $post = post::find($id);

        if (auth()->id() != $post->id_user && auth()->user()->role != 'admin') {
            return abort(403);
        }

        $post->delete();

<<<<<<< HEAD
=======
        if (request()->query('redirect') == 'home') {
            return redirect('/')->with('alert', [
                'type'=>'success',
                'message'=>'successfully deleted the post'
            ]);
        }

        return redirect()->back()->with('alert', [
            'type'=>'success',
            'message'=>'successfully deleted the post'
        ]);
    }

    public function destroyDetailPost($id)
    {
        $post = post::find($id);

        if (auth()->id() != $post->id_user && auth()->user()->role != 'admin') {
            return abort(403);
        }

        $post->delete();

>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
        return redirect('/')->with('alert', [
            'type'=>'success',
            'message'=>'successfully deleted the post'
        ]);
    }
}
