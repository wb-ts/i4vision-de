<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Schedule;
use App\Image;
use App\ScheduleEntry;
class SchedulesController extends Controller
{
    const PAGE_NAME = "schedules";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $schedules = Schedule::where('client_id', auth()->user()->client_id)->orderBy('client_id')->orderByDesc('id')->get();

        return view('admin/schedules/index', ['schedules' => $schedules, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/schedules/create', ['page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'string', 'unique:schedules', 'max:255'],
            'description' => 'required|string',
            'layout' => 'nullable|string|max:255',
        ]);
        
        $schedule = new Schedule($request->all());
        $schedule->client_id = auth()->user()->client_id;
        $schedule->user_id = auth()->user()->id;

        $schedule->save();

        return redirect(route('admin.schedules'))->with('success', 'A new schedule was created.');
    }
    public function clone(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'string', 'unique:schedules', 'max:255'],
            'description' => 'required|string',
            'layout' => 'nullable|string|max:255',
        ]);
        $schedule = new Schedule($request->all());
        $schedule->client_id = auth()->user()->client_id;
        $schedule->user_id = auth()->user()->id;

        $schedule->save();
        $schedule_previous = Schedule::where('name' , substr($schedule->name , 0 , -5))->get();
        $schedule_entries = ScheduleEntry::where('schedule_id', $schedule_previous[0]->id)->get();
        
        $schedule_current = Schedule::where('name' ,$schedule->name)->get();
        foreach ($schedule_entries as $schedule_entry) {
            unset($schedule_entry->id,$schedule_entry->created_at,$schedule_entry->updated_at);
            $new_schedule_entry['date'] = $schedule_entry->date;
            $new_schedule_entry['time'] = $schedule_entry->time;
            $new_schedule_entry['line1'] = $schedule_entry->line1;
            $new_schedule_entry['line2'] = $schedule_entry->line2;
            $new_schedule_entry['line3'] = $schedule_entry->line3;
            $new_schedule_entry['image_id'] = $schedule_entry->image_id;
            $new_schedule_entry['schedule_entriable_id'] = $schedule_entry->schedule_entriable_id;
            
            $n_schedule_entry = new ScheduleEntry($new_schedule_entry);
            $n_schedule_entry->schedule_id = $schedule_current[0]->id;
            $n_schedule_entry->user_id = auth()->user()->id;
            $n_schedule_entry->save();
        }
        return response()->json([
            'schedule' => $schedule,
        ]);
        //return redirect(route('admin.schedules'))->with('success', 'A new schedule was created.');
    }
    public function schudule_entry_clone(Request $request)
    {
        
        
        $schedule_entry = new ScheduleEntry($request->all());
        $schedule_entry->client_id = auth()->user()->client_id;
        $schedule_entry->user_id = auth()->user()->id;

        $schedule_entry->save();

        return response() -> json ([
            'schedule_entry' => $schedule_entry
        ]);
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $is_schedule_active = 1)
    {
        
        $schedule_list = Schedule::where('client_id',auth()->user()->client_id)->get();
        $schedule = Schedule::find($id);
        $schedule_entries= ScheduleEntry::where('schedule_id' , $schedule->id)->get();
		
        $images = Image:: where('user_id', $schedule->user_id )->get();  
		$temp_images = [];
		foreach($images as $image) {
			$temp_images[$image->id] = $image;
		}
        // print_r($images); exit();
        if (empty($schedule)) {
            return redirect(route('admin.schedules'))->with('warning', 'warning.');
        }

        return view('admin/schedules/edit', ['schedule' => $schedule, 'is_schedule_active' => $is_schedule_active, 'page_name' => self::PAGE_NAME , 'images' => $temp_images , 'schedule_list'=>$schedule_list ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'name' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('schedules')->ignore($id)
                        ],
            'description' => 'required|string',
            'layout' => 'nullable|string|max:255',
        ]);
        
        $schedule = Schedule::find($id);

        $schedule->fill($request->all());
        $schedule->save();

        return redirect(url('admin/schedules/' . $id . '/edit/is_schedule_active'))->with('success', 'A schedule was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect(url('admin/schedules'))->with('success', 'A schedule was deleted.');
    }


    public function schedule_entry_store(Request $request, $schedule_id, $is_schedule_active) {
        $validator = $request->validate([
			'schedule_entriable_id' => 'required'
        ]);

        $schedule_entry = new ScheduleEntry($request->all());
        $schedule_entry->schedule_id = $schedule_id;
        $schedule_entry->client_id = auth()->user()->client_id;

        $schedule_entry->user_id = auth()->user()->id;
        $schedule_entry->save();


        return redirect(url('admin/schedules/' . $schedule_id . '/edit/is_schedule_active/' . $is_schedule_active))->with('success', 'A new schedule entry was created.');
    }
    public function schedule_entry_clone(Request $request, $schedule_id, $is_schedule_active) {
        $validator = $request->validate([
			'schedule_entriable_id' => 'required'
        ]);

        $schedule_entry = new ScheduleEntry($request->all());
        $schedule_entry->schedule_id = $schedule_id;
        $schedule_entry->user_id = auth()->user()->id;
        $schedule_entry->save();

        return response()->json([
            'schedule_entry'=>$schedule_entry
        ]);
        //return redirect(url('admin/schedules/' . $schedule_id . '/edit/is_schedule_active/' . $is_schedule_active))->with('success', 'A new schedule entry was cloned.');
    }
    public function schedule_entry_move(Request $request, $id, $is_schedule_active) {
       
        $schedule_entry = ScheduleEntry::find($id);
        $schedule_entry->schedule_id = $request->schedule_id;
        $schedule_entry->user_id = auth()->user()->id;
        $schedule_entry->save();

        return response()->json([
            'schedule_entry'=>$schedule_entry
        ]);
    }
    public function get_schedule_entry($id, $schedule_entry_id) {

        $schedule_entry = ScheduleEntry::find($schedule_entry_id);
        $image = Image :: where('id' , $schedule_entry->image_id)->get();
        $schedule_entriable_names = collect();

        switch ($schedule_entry->schedule_entriable_id) {
            case 'kids':
            case 'adults':
            case 'general':
                $schedule_entriable_id = $schedule_entry->schedule_entriable_id;
                break;	
        }
        return response()->json([
            'schedule_entry' => $schedule_entry,
            'schedule_entriable_id' => $schedule_entriable_id,
            'images' => $image[0]
        ]);
    }

    public function schedule_entry_update(Request $request, $schedule_id, $schedule_entry_id, $is_schedule_active) {

        $validator = $request->validate([
			'schedule_entriable_id' => 'required',
        ]);

        $schedule_entry = ScheduleEntry::find($schedule_entry_id);
        $schedule_entry->fill($request->all());
        $schedule_entry->schedule_id = $schedule_id;
        $schedule_entry->user_id = auth()->user()->id;
        $schedule_entry->save();

        return redirect(url('admin/schedules/' . $schedule_id . '/edit/is_schedule_active/' . $is_schedule_active))->with('success', 'A schedule entry was updated.');

    }

    public function schedule_entry_delete($schedule_id, $schedule_entry_id) {
        ScheduleEntry::destroy($schedule_entry_id);

        return redirect(url('admin/schedules/' . $schedule_id . '/edit/is_schedule_active'))->with('success', 'A schedule entry was deleted.');

    }
}
