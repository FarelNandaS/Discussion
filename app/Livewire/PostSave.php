<?php

namespace App\Livewire;

use App\Models\post;
use Auth;
use Livewire\Component;

class PostSave extends Component
{
    public $post;
    public $isSaved;

    public function mount(post $post)
    {
        $this->post = $post;
        $this->isSaved = $post->isSavedByUser();
    }

    public function saves()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('alert', [
                'type' => 'warning',
                'message' => 'you are not logged in yet',
            ]);
        }

        $user = Auth::user();

        if ($this->post->isSavedByUser()) {
            $this->post->saves()->where('id_user', '=', $user->id)->delete();
            $this->isSaved = false;
        } else {
            $this->post->saves()->create(['id_user'=>$user->id]);
            $this->isSaved = true;
        }
    }

    public function render()
    {
        return view('livewire.post-save');
    }
}
