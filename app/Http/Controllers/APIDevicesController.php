<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device; 
use App\User;
use App\Image;
use App\Client; 
use App\Gallery;
use App\Site;
use App\Schedule;
use App\Flow;
class APIDevicesController extends Controller
{
    public function index(Request $request) {
        if (empty($request->all()) || $request->filled("google") || $request->filled("flow") || $request->filled("site") || $request->filled("schedule") || $request->filled("image")) {
            $data = [];
			if ($request->filled('title') && $request->title == "off") {
                $data['title'] = 'off';
            }

			if ($request->filled('border')) {
				$data['border'] = $request->border;
			}

			if ($request->filled('color')) {
				$data['color'] = $request->color;
			}

			if ($request->filled('design')) {
                $data['design'] = $request->design;
            }

            if ($request->filled('clientname')) {
                $client = Client::where('name', $request->clientname)->first();

                if (!empty($client)) {
                    if ($client->users->isNotEmpty()) {
                        foreach ($client->users as $user) {

                            if (!empty($user)) {

                                if ($request->filled("google")) {
                                    $gallery = Gallery::where('user_id', $user->id)->where('name', $request->google)->first();
                                    if ($gallery) {
                                        $data['google_images'] = $gallery->sync_google_images;
    									$data['label'] = "";
                                        if ($gallery->sync_google_images()->first()) {
                                            $data['label'] = $gallery->sync_google_images()->first()->title;
                                        }
                                    }

                                    return view('google_gallery', ['data' => $data]);
                                } elseif ($request->filled("site")) {

                                    $data['site'] = Site::where('user_id', $user->id)->where('name', $request->site)->first();

                                    return view('site', $data);
                                } elseif ($request->filled("image")) {
                                    $data['image'] = Image::where('user_id', $user->id)->where('name', $request->image)->first();

                                    return view('image', $data);
                                } elseif ($request->filled("schedule")) {
                                    $current_date = date('Y-m-d');
									$schedule = Schedule::where('name', $request->schedule)->first();
                                    $schedule_entries = $schedule->schedule_entries()->get();
									foreach ($schedule_entries as $schedule_entry) {
                                        $sch_date = date('Y-m-d',strtotime($schedule_entry->date));
                                        if($sch_date < $current_date) {
                                            continue;
                                        }
                                        $data['schedule_entries'][$schedule_entry->id] = $schedule_entry ;
                                        $data['images'][$schedule_entry->id] = Image::where('id',$schedule_entry->image_id)->get();
                                    }

                                    if ($data) {
                                    	return view('schedule', ['data' => $data] );
									}
                                } elseif ($request->filled("flow")) {

                                    $current_date = date('Y-m-d');
                                    $flow = Flow::where('name', $request->flow)->first();
                                    $flow_entries  = $flow->flow_entries()->orderBy('sequence')->get();
                                    foreach ($flow_entries as $flow_entry) {
                                        if ($flow_entry->run_from){
											if (!(date('Y-m-d' , strtotime($flow_entry->run_from)) < $current_date)) {
												continue;
											}
										}

										if ($flow_entry->run_to){
											if (!(date('Y-m-d' , strtotime($flow_entry->run_to)) > $current_date)) {
												continue;
											}
										}


                                        if ($flow_entry->flow_entriable_type == "App\Gallery") {
                                            $gallery = Gallery::find($flow_entry->flow_entriable_id);
                                            if ($gallery) {
                                                $data[$flow_entry->sequence]['google_images'][$flow_entry->id] = $gallery->sync_google_images;
                                                

												$data[$flow_entry->sequence]['title']['google_images'][$flow_entry->id] = "";
                                                if ($gallery->sync_google_images()->first()) {
                                                    $data[$flow_entry->sequence]['title']['google_images'][$flow_entry->id] = $gallery->sync_google_images()->first()->title;
                                                }
                                            }
                                        } elseif ($flow_entry->flow_entriable_type == "App\Site") {

                                            $data[$flow_entry->sequence]['sites'][$flow_entry->id] = Site::find($flow_entry->flow_entriable_id);
                                            $data[$flow_entry->sequence]['time']['sites'][$flow_entry->id] = $flow_entry->time;
                                        }
                                        elseif ($flow_entry->flow_entriable_type == "App\Image") {
                                            $data[$flow_entry->sequence]['images'][$flow_entry->id] = Image::find($flow_entry->flow_entriable_id);
                                            $data[$flow_entry->sequence]['time']['images'][$flow_entry->id] = $flow_entry->time;
                                            

                                        }  elseif ($flow_entry->flow_entriable_type == "App\Schedule") {

                                            $schedule = Schedule::where('name', $flow_entry->flow_entriable_id)->get();


											$data[$flow_entry->sequence]['schedule_entries'][$flow_entry->id] = $schedule[0]->schedule_entries()->get();
                                            $data[$flow_entry->sequence]['time']['schedule_entries'][$flow_entry->id] = $flow_entry->time;
                                            $data[$flow_entry->sequence]['schedule']['images'][$flow_entry->id] = Image::where('id',$data[$flow_entry->sequence]['schedule_entries'][$flow_entry->id][0]->image_id)->get();
                                            
                                        }

                                    }

									if ($data) {
                                    	return view('flow', ['data' => $data]);
									}
                                }
                            }


                        }
                    }
                }
            }
            return view('welcome', ['data' => $data]);
        }

		date_default_timezone_set('Europe/Berlin');
        $current_timestamp = date('Y-m-d H:i:s');

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $current_ip = $_SERVER['HTTP_CLIENT_current_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $current_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $current_ip = $_SERVER['REMOTE_ADDR'];
        }

        switch ($request->api){
            case "register":

                if (!$request->filled('device_code')) {
                    return "Error: Device register";
                }

                $device = Device::where("device_code", $request->device_code)->first();

                if (empty($device)) {

                    $device = new Device();
                    $device->device_code = $request->device_code;
                    $device->enabled = 0;
                    $device->timestamp_registered = $current_timestamp;
                    $device->timestamp_last_accessed = $current_timestamp;
                    $device-> timestamp_last_register = $current_timestamp;
                    $device->ip_address_of_last_access = $current_ip;
                    $device->force_restart_enabled = 0;
                    $device->save();

                    return response()->json(["info" => "New device registered, please wait for enabling"]);
                } else if($device->enabled) {
//                    $device_update = new Device();
                    $device_update = Device::find($device->id);
                    $device_update -> force_restart_enabled = 0;
                    $device_update -> timestamp_last_register = $current_timestamp;
					$device_update->force_restart_enabled = 0;
                    $device_update ->save();
					if ($device->client_id) {
                        $client_name = Client::where('id', $device->client_id)->get();
	                    return response()->json(["id"=>$device->client_id , "client_name" => $client_name[0]->name] );
					} else {
						return response()->json(["error" => "Not assign client"]);
					}
                }
                return response()->json(["error" => "Not yet enabled"]);

                break;
            case "setup":

                $device = Device::where("device_code", $request->device_code)->first();

                $device_update = Device::find($device->id);
                $device_update ->timestamp_last_setup = $current_timestamp;
                $device_update -> save();
                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

                $device = Device::select("device_code", "client_id", "enabled", "timestamp_registered", "eMail_of_admin", "configuration", "device_up_time", "device_down_time", "device_heartbeat_minutes", "timestamp_last_accessed", "ip_address_of_last_access","show_at_frontend","frontend_refer","frontend_layout")->where('device_code', $request->device_code)->where('client_id', $request->client_id)->first();

				if (empty($device)) {
					return response()->json(["error" => "Not register"]);
				}
				$len = strlen($device->show_at_frontend);
				$new_letter = strtolower($device->show_at_frontend);
				if($new_letter != "free") $new_letter = str_replace("app\\","",$new_letter);
				if($new_letter == "gallery") $new_letter = "google";
                return response()->json([
                    "configuration" => $device->configuration,
                    "ShowAtFrontend" => $new_letter,
                    "FrontendRefer" => $device->frontend_refer,
                    "Layout" => $device->frontend_layout,
                    "Heartbeat" => $device ->device_heartbeat_minutes
                ]);

                break;
            case "heartbeat":

                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

                $device = Device::where("device_code", $request->device_code)->where("client_id", $request->client_id)->first();

                if (empty($device)) {
                    return response()->json(["error" => "Not register"]);
                }

                $device->timestamp_last_accessed = $current_timestamp;

                

                $device->save();
				$force_restart = $device->force_restart_enabled == 0? "Off":"On";
				return response()->json([
					'status' => 'ok',
					'ForceRestart' => $force_restart,
                    'Index'=> $device->ix
				]);
        }
    }
}
