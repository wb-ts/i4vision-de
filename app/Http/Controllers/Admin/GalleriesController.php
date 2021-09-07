<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Gallery;

class GalleriesController extends Controller
{
    const PAGE_NAME = "galleries";

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

        $galleries = Gallery::where('client_id', auth()->user()->client_id)->orderBy('client_id')->orderByDesc('id')->get();

        return view('admin/galleries/index', ['galleries' => $galleries, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/galleries/create', ['page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $gallery = new Gallery($request->all());

        $gallery->client_id = auth()->user()->client_id;
        $gallery->user_id = auth()->user()->id;

        $gallery->save();

		
		
         return redirect(route('admin.galleries'))->with('success', 'A new gallery was created.');
    }
    public function clone(Request $request)
    {
        
        $gallery = new Gallery($request->all());

        $gallery->client_id = auth()->user()->client_id;

        $gallery->user_id = auth()->user()->id;

        $gallery->save();

		
		
         return redirect(route('admin.galleries'))->with('success', 'A new gallery was created.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return redirect(route('admin.galleries'))->with('warning', 'warning.');
        }

        return view('admin/galleries/edit', ['gallery' => $gallery, 'page_name' => self::PAGE_NAME]);
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
                            Rule::unique('galleries')->ignore($id)
                        ],
            'google_link' => 'required|string|max:255',
            'description' => 'nullable|string',
            
        ]);
        
        $gallery = Gallery::find($id);

        $gallery->fill($request->all());
        $gallery->save();

		
         return redirect(url('admin/galleries/' . $id . '/edit'))->with('success', 'A gallery was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gallery::destroy($id);
        return redirect(url('admin/galleries'))->with('success', 'A gallery was deleted.');
    }
}
