<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $fillable = [
        'name', 'description', 'layout',
    ];

    public function flow_entries()
    {
        return $this->hasMany(FlowEntry::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    
}
