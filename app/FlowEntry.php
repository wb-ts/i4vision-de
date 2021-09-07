<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowEntry extends Model
{

    protected $fillable = [
        'sequence', 'flow_entriable_type', 'flow_entriable_id', 'time', 'run_from', 'run_to', 'dates'
    ];

    public function flow_entriable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
