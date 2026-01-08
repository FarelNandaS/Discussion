<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $table = 'reactions';

    protected $fillable = ['user_id', 'reactable_type', 'reactable_id', 'type'];

    public function reactable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
