<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }
    
    public function reported() {
        return $this->belongsTo(User::class, 'reported_id', 'id');
    }

    public function reportable() {
        return $this->morphTo();
    }
}
