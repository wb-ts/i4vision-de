<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name', 'description', 'layout',
    ];

    public function schedule_entries()
    {
        return $this->hasMany(ScheduleEntry::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    
}
