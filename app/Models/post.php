<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "id_user",
        "title",
        "content",
        "image",
        "up_vote_count",
        "down_vote_count",
    ];

    public function user() {
        return $this->belongsTo(User::class, "id_user");
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'id_post');
    }

    public function reaction() {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function upVotes() {
        return $this->reaction()->where('type', 'up');
    }

    public function downVotes() {
        return $this->reaction()->where('type', 'down');
    }

    public function saves() {
        return $this->hasMany(Saved::class,'id_post');
    }

    public function isSavedByUser() {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->saves()->where('id_user', '=', $user->id)->exists();
        } else {
            return false;
        }
    }

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function appeals() {
        return $this->morphMany(Appeals::class, 'content');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
}
