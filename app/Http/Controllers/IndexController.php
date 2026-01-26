<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\post;
use App\Models\Tag;
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
        $recommendation = post::where('isDelete', false)->inRandomOrder()->take('10')->get();

        if (!empty($recommendation)) {
            $posts['recommendation'] = $recommendation;
        }

        return view("pages.home", [
            'posts' => $posts,
        ]);
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function Profile(Request $request, $username)
    {
        $user = user::where('username', '=', $username)->get()->first();

        if (empty($user)) {
            return view('pages.not-found');
        }

        $posts = $user->posts()->where('isDelete', false)->simplePaginate(10);

        if ($request->ajax()) {
            return view('components.post', compact('posts'))->render();
        }

        return view('pages.profile', [
            'user' => $user,
            'posts' => $posts,
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
        $isSuspend = auth()->user()->detail->suspend_until > now();

        return view('pages.post', [
            'isSuspend' => $isSuspend
        ]);
    }

    public function postEdit($id)
    {
        $post = post::find($id);

        return view('pages.edit-post', ['post' => $post]);
    }

    public function DetailPost(Request $request, $id)
    {
        $post = Post::find($id);
        $comments = Comment::where([
            'id_post' => $post->id,
            'isDelete' => false
        ])->latest()->simplePaginate(10);

        if ($post->isDelete) {
            abort(404);
        }

        if ($request->ajax()) {
            return view('components.comment', compact('comments'))->render();
        }

        return view('pages.detail-post', [
            'post' => $post,
            'comments' => $comments,
        ]);
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

        $posts = post::where('isDelete', false)->where('title', 'like', '%' . $key . '%')->orWhere('content', 'like', '%' . $key . '%')->latest()->simplePaginate(10);
        $users = user::where('username', 'like', '%' . $key . '%')->take(10)->get();

        if ($request->ajax()) {
            return view('components.post', compact('posts'))->render();
        }

        return view('pages.search', [
            'key' => $key,
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function newest()
    {
        $post = post::where('isDelete', false)->latest()->take('10')->get();

        return view('pages.newest', [
            'posts' => $post,
        ]);
    }

    public function saved()
    {
        $user = Auth::user();
        $posts = $user->saves()->where('isDelete', false)->get();

        return view('pages.saved', [
            'posts' => $posts,
        ]);
    }

    public function settings()
    {
        $logs = TrustScoreLog::where('user_id', auth()->user()->id)->orderByDesc('created_at')->take(20)->get();

        return view('pages.settings', ['logs' => $logs]);
    }

    public function inbox()
    {
        $user = auth()->user();
        $notifications = $user->notifications;

        $groupedNotifications = $notifications->reduce(function ($carry, $item) {
            $lastGroup = $carry->last();

            $isReaction = isset($item->data['type']) && $item->data['type'] == 'reaction';
            $contentId = $item->data['content_id'] ?? null;

            if ($lastGroup && $lastGroup['type'] == 'reaction' && $isReaction && $lastGroup['content_id'] == $contentId) {
                $lastGroup['items'][] = $item;

                $lastGroup['items_count']++;
                $reactionType = $item->data['reaction_type'] ?? '';
                if ($reactionType == 'up')
                    $lastGroup['upvotes']++;
                if ($reactionType == 'down')
                    $lastGroup['downvotes']++;

                $carry->pop();
                $carry->push($lastGroup);
            } else {
                if ($isReaction) {
                    $carry->push([
                        'type' => 'reaction',
                        'content_id' => $contentId,
                        'content_type' => $item->data['content_type'],
                        'title' => $item->data['content_title'] ?? 'Untitled',
                        'upvotes' => $item->data['reaction_type'] == 'up' ? 1 : 0,
                        'downvotes' => $item->data['reaction_type'] == 'down' ? 1 : 0,
                        'items_count' => 1,
                        'read_at' => $item->read_at,
                        'created_at' => $item->created_at,
                        'first_items' => $item,
                    ]);
                } else {
                    $carry->push($item);
                }
            }

            return $carry;
        }, collect());
        // dd($groupedNotifications);
        return view('pages.inbox', ['notifications' => $groupedNotifications]);
    }

    public function inboxDetail($id)
    {
        $notif = auth()->user()->notifications()->find($id);

        $notif->markAsRead();

        return view('pages.detail-inbox', ['notification' => $notif]);
    }

    public function tags() {
        $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->simplePaginate(40);

        return view('pages.tags', compact('tags'));
    }

    public function tagPost(Request $request, $slug) {
        $tag = Tag::where([
            'slug'=>$slug,
        ])->first();

        $posts = $tag->posts()->simplePaginate(10);

        if ($request->ajax()) {
            return view('components.post', compact('posts'))->render();
        }

        return view('pages.tagPost', compact('tag', 'posts'));
    }
}
