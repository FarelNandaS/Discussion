<?php

namespace App\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $type = 'post';
    public $posts;
    public $users;
    public $key;

    public function mount($users, $posts, $key) {
        $this->users = $users;
        $this->posts = $posts;
        $this->key = $key;
    }

    public function changeSearch($type) {
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.search', [
            'type'=> $this->type,
            'posts'=> $this->posts,
            'users'=> $this->users,
            'key'=> $this->key,
        ]);
    }
}
