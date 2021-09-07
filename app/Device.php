<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'device';
    protected $fillable = [
        'device_code', 'description', 'timestamp_registered', 'timestamp_last_accessed', 'timestamp_last_setup' , 'force_restart_enabled' , 'timestamp_last_register' , 'show_at_frontend','frontend_refer','frontend_layout','ix'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}