<?php

namespace App\Livewire;

use App\Models\post;
use Auth;
use Livewire\Component;

class PostLike extends Component
{
    public $post;
    public $isLiked;
    public $likeCount;

    public function mount(post $post) {
        $this->post = $post;
        $this->isLiked = $post->isLikedByUser();
        $this->likeCount = $post->likes()->count();
    }

    public function likes() {
        if (!Auth::check()) {
            return redirect('/login')->with('alert', [
                'type'=>'warning',
                'message'=>'you are not logged in yet',
            ]);
        }

        $user = Auth::user();

        if ($this->post->isLikedByUser()) {
            $this->post->likes()->where('id_user', '=', $user->id)->delete();
            $this->isLiked = false;
        } else {
            $this->post->likes()->create(['id_user'=>$user->id]);
            $this->isLiked = true;
        }

        $this->likeCount = $this->post->likes()->count();
    }

    public function render()
    {
        return view('livewire.post-like');
    }
}
