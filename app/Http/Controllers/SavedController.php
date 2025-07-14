<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\saved;
use Auth;
use Illuminate\Http\Request;

class SavedController extends Controller
{
    public function toggleSave($id) {
        $post = post::find($id);
        $user = Auth::user();
        $saved = $post->isSavedByUser();

        if ($saved) {
            $post->saves()->where('id_user', '=', $user->id)->delete();
            $saved = false;
        } else {
            $post->saves()->create(['id_user'=>$user->id]);
            $saved = true;
        }

        return response()->json([
            'saved'=>$saved,
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
    public function show(saved $saved)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(saved $saved)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, saved $saved)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(saved $saved)
    {
        //
    }
}
