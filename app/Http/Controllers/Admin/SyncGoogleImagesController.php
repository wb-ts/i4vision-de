<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SyncGoogleImage;
use App\Gallery;

class SyncGoogleImagesController extends Controller
{
    public function save(Request $request) {

        if ($request->number == 1) {
            $gallery = Gallery::find($request->gallery_id);
            
            if (empty($gallery)) {
                return;
            }

            if ($gallery->sync_google_images->isNotEmpty()) {
                $gallery->sync_google_images()->delete();
            }
        }

        $sync_google_image = new SyncGoogleImage();

        $sync_google_image->gallery_id = $request->gallery_id;
        $sync_google_image->url = $request->url;
		$sync_google_image->title = $request->title;
        $sync_google_image->save();

        return $sync_google_image;
    }
}
