<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
                $request->all(),
                [
                    "title" => "required|String",
                    "post" => "required|String",
                    "image" => 'nullable|image',
                    "tags" => 'nullable|String'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('alert', ['type' => 'error', 'message' => $validator->errors()->first()]);
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // $fileNameOG = pathinfo()
                $fileName = $file->getFilename() . time() . "." . $file->extension();
                $file->move(public_path("storage/posts"), $fileName);
            }
            ;

            // dd($request);

            $post = Post::create([
                'id_user' => $user->id,
                'title' => $request->title,
                'content' => $request->post,
                'image' => $fileName ?? null,
            ]);

            if ($request->tags) {
                $tagData = json_decode($request->tags, true);

                $tagIds = [];
                foreach ($tagData as $data) {
                    $tagName = trim($data['value']);

                    $tag = Tag::firstOrCreate([
                        'name' => $tagName,
                        'slug' => Str::slug($tagName),
                    ]);

                    $tagIds[] = $tag->id;

                    $post->tags()->sync($tagIds);
                }
            }

            return redirect('/')->with('alert', [
                'type' => 'success',
                'message' => 'successfully created a post'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
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

            if ($request->hasFile('image')) {
                if ($post->image && $post->image !== null) {
                    $oldImagePath = public_path('storage/posts/' . $post->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file = $request->file('image');
                // $fileNameOG = pathinfo()
                $fileName = $file->getFilename() . time() . "." . $file->extension();
                $file->move(public_path("storage/posts"), $fileName);
            } else if ($request->remove_image == '1') {
                if ($post->image && $post->image !== null) {
                    $oldImagePath = public_path('storage/posts/' . $post->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $fileName = null;
            }
            ;

            if ($request->tags) {
                $tagData = json_decode($request->tags, true);

                $tagIds = [];
                foreach ($tagData as $data) {
                    $tagName = trim($data['value']);

                    $tag = Tag::firstOrCreate([
                        'name' => $tagName,
                        'slug' => Str::slug($tagName),
                    ]);

                    $tagIds[] = $tag->id;

                    $post->tags()->sync($tagIds);
                }
            } else {
                $post->tags()->detach();
            }

            $post->update([
                'title' => $request->title,
                'content' => $request->post,
                'image' => $fileName ?? null,
            ]);

            return redirect()->route('detail-post', ['id' => $request->id])->with('alert', ['type' => 'success', 'message' => 'successfully update post']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
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
            'type' => 'success',
            'message' => 'successfully deleted the post'
        ]);
    }

    public function savePost(Request $request)
    {
        try {
            $user = Auth::user();
            $post = Post::findOrFail($request->id);

            if ($post->isSavedByUser()) {
                $post->saves()->where('id_user', $user->id)->delete();
            } else {
                $post->saves()->create(['id_user' => $user->id]);
            }

            return response()->json(array('status' => 'success', 'message' => 'success to save the post', 'saved' => $post->isSavedByUser()));
        } catch (\Exception $e) {
            return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    public function getWhitelistTagify()
    {
        return Tag::pluck('name')->toArray();
    }
}