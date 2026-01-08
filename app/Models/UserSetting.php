<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'user_settings';
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
