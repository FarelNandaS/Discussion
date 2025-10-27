<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remember_Me extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'device',
        'platform',
        'created_at'
    ];
}
