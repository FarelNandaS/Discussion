<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $fillable = [
        "id_user",
        "id_post",
    ];

    public function user() {
        return $this->belongsTo(user::class, "id_user");
    }
    
    public function post() {
        return $this->belongsTo(post::class, "id_post");
    }
}
