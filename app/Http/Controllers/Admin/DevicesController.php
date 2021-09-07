<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Device;
use App\User;
use App\Client;
use App\Schedule;
use App\Flow;
use App\Image;
use App\Site;

class DevicesController extends Controller
{
    const PAGE_NAME = "devices";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
		if(auth()->user()->type == "super_admin") {
	        $devices = Device::orderByDesc('id')->get();
		} else {
			$devices = Device::orderByDesc('id')->where('client_id', auth()->user()->client_id)->get();
		}
        return view('admin/devices/index', ["devices" => $devices, 'page_name' => self::PAGE_NAME]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $device = Device::find($id);

        if (empty($device)) {
            return redirect(route('devices'))->with('warning', 'warning.');
        }

		if (auth()->user()->type == "super_admin") {
			$clients = Client::orderBy('name')->get();
		} else {
			$clients = Client::where('id', auth()->user()->client_id)->get();
		}
        return view('admin/devices/edit', ['device' => $device, 'clients' => $clients, 'page_name' => self::PAGE_NAME]);
    }

    public function update(Request $request, $id) {
		$rules = [
            'device_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('device')->ignore($id)
            ]

        ];

		if (auth()->user()->type == "super_admin") {
			$rules['client_id'] = 'required|integer|exists:clients,id';
		}
        $validator = $request->validate($rules);

        $device = Device::find($id);
        $device->device_code = $request->device_code;
        $device->enabled = $request->enabled;
        $device->configuration = $request->configuration;
		if (auth()->user()->type == 'super_admin') {
			$device->client_id = $request->client_id;
			$device->configuration = $request->configuration;

		} else {
			if (auth()->user()->client_id) {
				$device->client_id = auth()->user()->client_id;
			}

			if ($request->has('device_up_time')) {
				$device->device_up_time = $request->device_up_time;
			}
			if($request->has('frontend_refer')) {
				$device->frontend_refer = $request->frontend_refer;
			}
            if($request->has('force_restart_enabled')){
                $device->force_restart_enabled = $request->force_restart_enabled;
            }
			if($request->has('frontend_layout')){
				$device->frontend_layout = $request->frontend_layout;
			}
			if($request->has('show_at_frontend')){
				$device->show_at_frontend = $request->show_at_frontend;
			}
			if ($request->has('device_down_time')) {
				$device->device_down_time = $request->device_down_time;
			}

			

            if ($request->has('description')) {
				$device->description = $request->description;
			}

			if ($request->has('device_heartbeat_minutes')) {
				$device->device_heartbeat_minutes = $request->device_heartbeat_minutes;
			}
		}
		$device->save();

        return redirect(url('admin/devices'))->with('success', 'A device was updated.');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return redirect(url('admin/devices'))->with('success', 'A device was deleted.');
    }

    public function get_frontend_refers(Request $request) {
        $get_frontend_refers = collect();

        switch ($request->show_at_frontend) {
            case 'App\Image':
            case 'App\Gallery':
            case 'App\Site':
                $get_frontend_refers = $request->show_at_frontend::where('user_id', auth()->user()->id)->orderBy('name')->get();
                break;
            case 'App\Device':
                $get_frontend_refers = $request->show_at_frontend::where('user_id', auth()->user()->id)->orderBy('device_code')->get();
                break;
            case 'App\Flow':
                $get_frontend_refers = $request->show_at_frontend::where('user_id', auth()->user()->id)->orderBy('name')->get();
                break;
            case 'App\Schedule':
                $get_frontend_refers = Schedule::select('name')->where('user_id', auth()->user()->id)->groupBy('name')->orderBy('name')->get();
                break;
        }

        return response()->json([
            'frontend_refers' => $get_frontend_refers,
        ]);
    }
    public function get_device(Request $request) {
        $device = Device::find($request->id);
        $get_frontend_refers = collect();

        switch ($request->show_at_frontend) {
            case 'App\Image':
            case 'App\Gallery':
            case 'App\Site':
                $get_frontend_refers = $request->show_at_frontend::where('user_id', auth()->user()->id)->orderBy('name')->get();
                break;
            case 'App\Device':
                $get_frontend_refers = $request->show_at_frontend::where('user_id', auth()->user()->id)->orderBy('device_code')->get();
                break;
            case 'App\Schedule':
                $get_frontend_refers = Schedule::select('name')->where('user_id', auth()->user()->id)->groupBy('name')->orderBy('name')->get();
                break;
        }

        return response()->json([
            'device' => $device ,
            'frontend_refers' => $get_frontend_refers,
        ]);
    }
}
