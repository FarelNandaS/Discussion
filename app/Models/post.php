<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        "id_user",
        "title",
        "post",
        "like"
    ];

    public function user() {
        return $this->belongsTo(user::class, "id_user");
    }

    public function comments() {
        return $this->hasMany(comment::class, 'id_post');
    }

    public function likes() {
        return $this->hasMany(like::class, 'id_post');
    }

    public function saves() {
        return $this->hasMany(saved::class,'id_post');
    }

    public function isLikedByUser() {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->likes()->where('id_user', '=', $user->id)->exists();
        } else {
            return false;
        }
    }

    public function isSavedByUser() {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->saves()->where('id_user', '=', $user->id)->exists();
        } else {
            return false;
        }
    }
}
