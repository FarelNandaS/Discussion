<?php

namespace App\Livewire;

use App\Models\user;
use Auth;
use Livewire\Component;

class ProfileContent extends Component
{
    public $type = 'posts';
    public $username;

    public function mount($username) {
        $this->username = $username;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function render()
    {
        $user = user::with(['posts', 'comments', 'likes.post'])->where('username', '=', $this->username)->first();

        $content = match($this->type) {
            'posts'=>$user->posts,
            'comments'=>$user->comments,
            'likes'=>$user->likes->map->post,
        };

        return view('livewire.profile-content', [
            'content'=>$content,
            'type'=>$this->type, 
        ]);
    }
}
