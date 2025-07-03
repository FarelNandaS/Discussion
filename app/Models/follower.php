<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class follower extends Model
{
    protected $fillable = [
        'user_id',
        'follower_id'
    ];
}
