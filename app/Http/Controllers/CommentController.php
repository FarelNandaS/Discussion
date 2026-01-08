<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
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
        $validator = Validator::make($request->all(), [
            'comment'=>'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('alert', [
                'type'=>'error',
                'message'=> $validator->errors()->first(),
            ]);
        }

        Comment::create([
            'id_user'=>auth()->user()->id,
            'id_post'=>$request->id,
        'content'=> $request->comment,
        ]);

        return redirect()->back()->with('alert', [
            "type"=>'success',
            'message'=>'successfully added a comment',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);

        if (auth()->id() != $comment->id_user && auth()->user()->role != 'admin') {
            return abort(403);
        }

        $comment->delete();
        
        return redirect()->back()->with('alert', [
            'type'=> 'success',
            'message'=>'successfully deleted comment',
        ]);
    }
}
