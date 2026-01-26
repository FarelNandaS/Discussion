<?php

namespace App\Models;

use App\Notifications\QueuedResetPassword;
use App\Notifications\QueuedVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, Notifiable;

    protected $guard_name = 'web';
    protected $fillable = [
        "username",
        "email",
        "email_verified_at",
        "password",
        "info",
        "gender",
        "google_id"
    ];

    public function detail() {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'id_user');
    }

    public function comments() {
        return $this->hasMany(Comment::class,'id_user');
    }

    public function saves() {
        return $this->belongsToMany(Post::class,'saveds', 'id_user', 'id_post');
    }

    public function hasSaved($postId) {
        return $this->saves()->where('id_post', $postId)->exists();
    }
    
    public function reactions() {
        return $this->hasMany(Reaction::class, 'user_id', 'id');
    }

    public function reactPost($postId) {
        return $this->reactions()->where('reactable_type', Post::class)->where('reactable_id', $postId)->first();
    }

    public function reactedPosts() {
        return $this->morphedByMany(Post::class, 'reactable', 'reactions');
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new QueuedVerifyEmail());
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new QueuedResetPassword($token));
    }
}
