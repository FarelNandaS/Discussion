<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\post;
use App\Models\TrustScoreLog;
use App\Models\user;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $posts = [];
        $recommendation = post::inRandomOrder()->take('10')->get();

        if (!empty($recommendation)) {
            $posts['recommendation'] = $recommendation;
        }

        return view("pages.home", [
            'posts' => $posts,
        ]);
    }

    public function login()
    {
        return view('pages.login');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function Profile($username)
    {
        $user = user::where('username', '=', $username)->get()->first();

        if (empty($user)) {
            return view('pages.not-found');
        }
        
        $posts = $user->posts;
        $likes = $user->likes;

        return view('pages.profile', [
            'user' => $user,
            'posts' => $posts,
            'likes' => $likes,
        ]);
    }

    public function EditProfile()
    {
        $user = auth()->user();
        return view('pages.editProfile', [
            'user' => $user,
        ]);
    }

    public function post()
    {
        return view('pages.post');
    }

    public function postEdit($id) {
        $post = post::find($id);

        return view('pages.edit-post', ['post'=>$post]);
    }

    public function DetailPost($id)
    {
        $post = Post::find($id);
        $comments = Comment::where('id_post', '=', $post->id)->latest()->get();
        if (isset($post)) {
            return view('pages.detail-post', [
                'post' => $post,
                'comments' => $comments,
            ]);
        }
    }

    public function search(Request $request, )
    {
        $key = $request->key;

        $validator = Validator::make([
            'key' => $key,
        ], [
            'key' => "required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $posts = post::where('title', 'like', '%' . $key . '%')->orWhere('content', 'like', '%' . $key . '%')->get();
        $users = user::where('username', 'like', '%' . $key . '%')->get();

        return view('pages.search', [
            'key' => $key,
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function newest()
    {
        $post = post::latest()->take('10')->get();

        return view('pages.newest', [
            'posts' => $post,
        ]);
    }

    public function saved()
    {
        $user = Auth::user();
        $posts = $user->saves;

        return view('pages.saved', [
            'posts' => $posts,
        ]);
    }

    public function dashboard() {
        return view();
    }

    public function settings() {
        $logs = TrustScoreLog::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();

        return view('pages.settings', ['logs'=>$logs]);
    }
}
