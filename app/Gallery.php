<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'name', 'description', 'google_link',
    ];
	
	public function sync_google_images()
    {
        return $this->hasMany(SyncGoogleImage::class);
    }
}
