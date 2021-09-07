<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Image;

class ImagesController extends Controller
{
    const PAGE_NAME = "images";

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

        $images = Image::where('client_id', auth()->user()->client_id)->orderBy('client_id')->orderByDesc('id')->get();

        return view('admin/images/index', ['images' => $images, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/images/create', ['page_name' => self::PAGE_NAME]);
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
            'file' => 'required|image',
        ]);

        $image = new Image($request->all());
        $image->url = Str::of($request->file->store('public/images'))->after('public/');
        $request->file->move(public_path('storage/images'), $image->url->after('images'));
        $image->client_id = auth()->user()->client_id;
        $image->user_id = auth()->user()->id;

        $image->save();

        return redirect(route('admin.images'))->with('success', 'A new image was created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::find($id);

        if (empty($image)) {
            return redirect(route('admin.images'))->with('warning', 'warning.');
        }

        return view('admin/images/edit', ['image' => $image, 'page_name' => self::PAGE_NAME]);
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
        $request->validate([
            'name' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('images')->ignore($id)
                        ],
            'file' => 'nullable|image',
        ]);
        $image = Image::find($id);
        if ($request->file) {
            Storage::delete('public/' . $image->url);
            $image->url = Str::of($request->file->store('public/images'))->after('public/');
            $request->file->move(public_path('storage/images'), $image->url->after('images'));
        }

        $image->fill($request->all());
        $image->save();

        return redirect(url('admin/images/' . $id . '/edit'))->with('success', 'A image was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        Storage::delete('public/' . $image->url);
        $image->delete();
        return redirect(url('admin/images'))->with('success', 'A image was deleted.');
    }
}
