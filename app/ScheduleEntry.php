<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleEntry extends Model
{

    protected $fillable = [
        'schedule_entriable_id' , 'date' , 'time', 'line1' , 'line2' , 'line3' , 'image_id','run_from','run_to','dates'
    ];

    public function schedule_entriable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
