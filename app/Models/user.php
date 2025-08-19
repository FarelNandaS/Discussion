<?php

namespace App\Models;

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
}
