<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';
    protected $fillable = ['user_id', 'bio', 'gender', 'image', 'trust_score', 'suspend_until'];
    protected $casts = [
        'suspend_until' => 'datetime',
    ];

    public function setTrustScoreAttribute($value)
    {
        $this->attributes['trust_score'] = max(0, min(100, (int) $value));
    }
}
