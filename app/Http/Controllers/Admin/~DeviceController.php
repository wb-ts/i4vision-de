<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Http\Resources\DevieceCollection;
use App\Device;


class DeviceController extends Controller
{
    const PAGE_NAME = "devices";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $devices = Device::orderByDesc('id')->get();
        return view('devices/index', ["devices" => $devices]);
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

        return view('devices/edit', ['device' => $device, 'page_name' => self::PAGE_NAME]);
    }

    public function update(Request $request, $id) {
        $validator = $request->validate([
            'device_code' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('device')->ignore($id)
                        ],
            // 'client_id' => 'required|integer|exists:clients,id',
            'enabled' => 'required|boolean',
            'timestamp_last_accessed' => 'nullable|string',
            
        ]);
        
        $device = Device::find($id);

        $device->device_code = $request->device_code;
        $device->client_id = $request->client_id;
        $device->enabled = $request->enabled;
        $device->timestamp_last_accessed = $request->timestamp_last_accessed;
        $device->save();

        return redirect(url('devices/' . $id . '/edit'))->with('success', 'A feature was updated.');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return redirect(url('devices'))->with('success', 'A feature was deleted.');
    }

    public function api_index(Request $request) {
        return $request->api;
        switch ($request->api){
            case "register":

                if (!$request->device_code) {
                    return "Empty";
                }

                $device = Device::where("device_code", $request->device_code)->first();
                
                if (empty($device)) {

                    $device = new Device($request->all());
                    $device->enabled = 0;
                    $device->save();

                    return "New device registered, please wait for enabling";
                } else if($device->enabled) {

                    return "It’s assigned client id";
                }
                return "Not yet enabled";

                break;
            case "setup":

                $devices = Device::select("*");
                if ($request->device_id) {
                    $devices->where('device_id', $request->device_id);
                }

                if($request->client_id) {
                    $devices = $devices->where('client_id', $request->client_id);
                }


                return $devices->get()->toJson();

                break;
            case "heartbeat":

                if (!$request->filled("device_code")) {
                    return "Empty";
                }

                $device = Device::where("device_code", $request->device_code);

                if ($request->filled("client_id")) {
                    $device->where("client_id", $request->client_id);
                }


                $device = $device->first();

                if (empty($device)) {
                    return "Empty";
                }
                if ($request->filled("timestamp_last_accessed"))
                {
                    $device->timestamp_last_accessed = $request->timestamp_last_accessed;
                }

                if ($request->filled("ip_address_of_last_access")) {
                    $device->ip_address_of_last_access = $request->ip_address_of_last_access;
                }

                $device->save();
                return "Success";
        }
        // return DevieceCollection::collection(Device::orderBy("id")->get());
    }


}
