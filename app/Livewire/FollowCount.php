<?php

namespace App\Livewire;

use App\Models\user;
use Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FollowCount extends Component
{
    public user $user;
    public $followerCount;
    public $followingCount;

    public function mount($user) {
        $this->user = $user;
        $this->followerCount = $user->followers()->count();
        $this->followingCount = $user->following()->count();
    }

    #[On('followerUpdate')]
    public function refreshCount($data) {
        if ($data['idFollow'] == $this->user->id) {
            $this->followerCount = $this->user->followers()->count();
        }

        if ($data['idFollowers'] == $this->user->id) {
            $this->followingCount = $this->user->following()->count();
        }
    }

    public function render()
    {
        return view('livewire.follow-count');
    }
}
