<?php

namespace App\Livewire;

use App\Models\user;
use Auth;
use Livewire\Component;

class FollowButton extends Component
{
    public user $user;
    public $isFollowing;

    public function mount($user) {
        $this->user = $user;
        $this->isFollowing = Auth::user()->following->contains($user->id);
    }

    public function toggleFollow() {
        if (Auth::user()->following()->where('user_id', '=', $this->user->id)->exists()) {
            Auth::user()->following()->detach($this->user->id);
            $this->isFollowing = false;
        } else {
            Auth::user()->following()->attach($this->user->id);
            $this->isFollowing = true;
        }

        $this->dispatch('followerUpdate', [
            'idFollow'=>$this->user->id,
            'idFollowers'=>Auth::user()->id,
        ]);
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
