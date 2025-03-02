<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        "id_user",
        "post",
        "like"
    ];

    public function user() {
        return $this->belongsTo(user::class, "id_user");
    }
}
