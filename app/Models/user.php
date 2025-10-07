<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class user extends Authenticatable
{
    use HasRoles;

    protected $fillable = [
        "username",
        "email",
        "password",
        "info",
        "gender",
    ];

    public function detail() {
        return $this->hasOne(userDetail::class, 'user_id', 'id');
    }

    public function posts() {
        return $this->hasMany(post::class, 'id_user');
    }

    public function comments() {
        return $this->hasMany(comment::class,'id_user');
    }

    public function likes() {
        return $this->belongsToMany(post::class,'likes', 'id_user', 'id_post');
    }

    public function hasLiked($postId) {
        return $this->likes()->where('id_post', $postId)->exists();
    }

    public function saves() {
        return $this->belongsToMany(post::class,'saveds', 'id_user', 'id_post');
    }

    public function hasSaved($postId) {
        return $this->saves()->where('id_post', $postId)->exists();
    }

    public function followers() {
        return $this->belongsToMany(user::class, 'followers', 'user_id', 'follower_id');
    }

    public function following() {
        return $this->belongsToMany(user::class, 'followers', 'follower_id', 'user_id');
    }

    public function isFollowing($userId) {
        return $this->following()->where('user_id', $userId)->exists();
    }
}
