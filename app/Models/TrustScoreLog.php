<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustScoreLog extends Model
{
    protected $table = 'trust_score_logs';

    protected $fillable = [
        'user_id',
        'user_action_id',
        'change',
        'reason',
        'reference_type',
        'reference_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function userAction() {
        return $this->belongsTo(User::class, 'user_action_id', 'id');
    }

    public function reference() {
        $this->morphTo();
    }
}
