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
    //fungsi yang di panggil di halaman page
    public function home(Request $request)
    {
        //mengambil secara acak postingan
        $posts = [];
        $recommendation = post::where('isDelete', false)->inRandomOrder()->take('10')->get();

        if (!empty($recommendation)) {
            $posts['recommendation'] = $recommendation;
        }

        return view("pages.home", [
            'posts' => $posts,
        ]);
    }

    //fungsi controller di halaman login
    public function login()
    {
        return view('pages.auth.login');
    }

    //fungsi controller di halamn register
    public function register()
    {
        return view('pages.auth.register');
    }

    //fungsi controller di profile $username harus jadi parameter url setelah /profile/(username)
    public function Profile(Request $request, $username)
    {
        $user = user::where('username', '=', $username)->get()->first();

        //mengembalikan not found jika tidak di temukan
        if (empty($user)) {
            return view('pages.not-found');
        }

        $posts = $user->posts()->where('isDelete', false)->simplePaginate(10);

        //mengambil ajax dari infinity scroll di page ini membutuhkan param ?page=
        if ($request->ajax()) {
            return view('components.post', compact('posts'))->render();
        }

        return view('pages.profile', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    //fungsi controller di page edit profile
    public function EditProfile()
    {
        $user = auth()->user();
        return view('pages.editProfile', [
            'user' => $user,
        ]);
    }

    //fungsi controller di page add post
    public function post()
    {
        //mengambil apakah user tersuspend atau trust_score di bawah 70
        $isSuspend = (auth()->user()->detail->suspend_until > now() || auth()->user()->detail->trust_score < 70) ;
        // $isSuspend = false;

        return view('pages.post', [
            'isSuspend' => $isSuspend
        ]);
    }

    //fungsi controller di page edit post param $id di gunakan di url setelah /post/edit/(id disini)
    public function postEdit($id)
    {
        $post = post::find($id);

        return view('pages.edit-post', ['post' => $post]);
    }

    //fungsi controller di page edit post param $id di gunakan di url setelah /post/(id disini)
    public function DetailPost(Request $request, $id)
    {
        //mengambil post 
        $post = Post::find($id);

        //mengambil commentar yang tidak di hide/di hapus oleh sistem 
        $comments = Comment::where([
            'id_post' => $post->id,
            'isDelete' => false
        ])->latest()->simplePaginate(10);

        //mengembalikan code 404 jika terdelete
        if ($post->isDelete) {
            abort(404);
        }

        //mengambil ajax untuk infinity scroll di page ini
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

        //memvalidasi 
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

        $posts = post::where('isDelete', false)->where('title', 'like', '%' . $key . '%')->orWhere('content', 'like', '%' . $key . '%')->orWhereHas('tags', function ($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%');
        })->orWhereHas('user', function ($query) use ($key) {
            $query->where('username', 'like', '%' . $key . '%');
        })->latest()->simplePaginate(10);
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
            $contnetType = $item->data['content_type'] ?? null;

            if ($lastGroup && $lastGroup['type'] == 'reaction' && $isReaction && $lastGroup['content_id'] == $contentId && $lastGroup['content_type'] == $contnetType) {
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
                        'content_type_human'=>str_contains($item->data['content_type'], 'Post') ? 'post' : (str_contains($item->data['content_type'], 'Comment') ? 'comment' : 'null'),
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

        if ($notif->data['type'] == 'reaction') {
            return redirect()->route('detail-post', ['id'=>$notif->data['content_id']]);
        }

        return view('pages.detail-inbox', ['notification' => $notif]);
    }

    public function inboxDetailReaction($type, $id) {
        $morphClass = $type == 'post' ? Post::class : Comment::class;

        auth()->user()->notifications()->where([
            'data->type'=>'reaction',
            'data->content_type'=>$morphClass,
            'data->content_id'=>$id,
        ])->update([
            'read_at'=>now()
        ]);
        // dd($type);
        if ($type == 'post') {
            return redirect()->route('detail-post', ['id'=>$id]);
        } else if ($type == 'comment') {
            $comment = Comment::find($id);

            return redirect()->route('detail-post', ['id'=>$comment->post->id]);
        } else {
            return abort(404);
        };
    }

    public function tags(Request $request) {
        $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->simplePaginate(20);

        if ($request->ajax()) {
            return view('components.tag', compact('tags'))->render();
        }

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
