<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SyncGoogleImage;
use App\Gallery;

use GuzzleHttp\Client;

class Crawler {

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $data;

    /**
     * Crawler constructor.
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        if ($client === null) {
            $this->client = new Client();
        } else {
            $this->client = $client;
        }
    }

    /**
     * Fetch a google photo album using the public url
     * will return:
     *  id: id of the album
     *  name: name of the album
     *  images[]:
     *      id: id of the image
     *      url: the base url to download the image
     *      width: the max width of the image
     *      height: the max height of the image
     *
     * @param $url
     * @return array
     */
    public function getAlbum($url)
    {
        $response = $this->client->get($url);
        $html = $response->getBody()->getContents();
        $re = '/<script nonce="[^"]+">AF_initDataCallback\(\{[^<]+, data:([^<]+)\}\);<\/script>/m';
        preg_match_all($re, $html, $matches, PREG_SET_ORDER, 0);
        $json = str_replace(', sideChannel: {}', '', $matches[0][1]);
        $data = json_decode($json, true);
        $images = array_map(function ($image) {
            // . '=w4032-h2268-no'
            //  . '=w' . $image[1][1] . '-h' . $image[1][2] . '-no'
            return [
                'id' => $image[0],
                // default url
                'url' => $image[1][0] . '=w' . $image[1][1] . '-h' . $image[1][2] . '-no',
                // max size
                'width' => $image[1][1],
                'height' => $image[1][2]
            ];
        }, $data[1]);
        $this->data = [
            'id' => $data[3][0],
            'name' => $data[3][1],
            'images' => $images
        ];
        return $this->data;
    }
}

class SyncGoogleImagesController extends Controller
{
    public function save(Request $request) {

        $url = $request->albumURI;

        $crawler = new Crawler();
        
        $album = $crawler->getAlbum($url);
        
        $number = 0;

        foreach ($album['images'] as $image) {
       
                $number += 1;
            if ($number == 1) {
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
            $sync_google_image->url = $image['url'];
            $sync_google_image->title = $album['name'];
            $sync_google_image->save();
        }

        return "congratulation!";
    }
}
