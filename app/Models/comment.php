<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        "id_user",
        "id_post",
        "content",
    ];

    public function user() {
        return $this->belongsTo(User::class, "id_user", 'id');
    }
    
    public function post() {
        return $this->belongsTo(Post::class, "id_post", 'id');
    }
}
