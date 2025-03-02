<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    protected $fillable = [
        "username",
        "password",
        "info",
        "gender",
    ];
}
