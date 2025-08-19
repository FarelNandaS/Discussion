<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Auth;
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    protected $fillable = [
        "username",
        "email",
        "password",
        "info",
        "gender",
    ];

    public function posts() {
        return $this->hasMany(post::class, 'id_user');
    }

    public function comments() {
        return $this->hasMany(comment::class,'id_user');
    }

    public function likes() {
        return $this->belongsToMany(post::class,'likes', 'id_user', 'id_post');
    }

    public function saves() {
        return $this->belongsToMany(post::class,'saveds', 'id_user', 'id_post');
    }

    public function followers() {
        return $this->belongsToMany(user::class, 'followers', 'user_id', 'follower_id');
    }

    public function following() {
        return $this->belongsToMany(user::class, 'followers', 'follower_id', 'user_id');
    }
<<<<<<< HEAD
=======

    public function isFollowedByUser() {
        $user = Auth::user();
        
        if (Auth::check()) {
            return $this->followers()->where('follower_id', '=', $user->id)->exists();
        } else {
            return false;
        }
    }
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
}
