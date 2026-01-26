<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class Appeals extends Model
{
    protected $table = 'appeals';
    protected $fillable = [
        'user_id',
        'notification_id',
        'content_id',
        'content_type',
        'message',
        'admin_id',
        'admin_reason',
        'status'
    ];

    public function content() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
