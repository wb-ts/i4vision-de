<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin/profile', ['user' => auth()->user()]);
    }

    public function update(Request $request, $id) {

        $request->validate([
            'email' => ['required', 
                        'string',
                        'email',
                        'max:255',
                        Rule::unique('users')->ignore($id)
                    ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'boolean'],
            'phone' => ['required', 'string', 'max:255'],
            'profile' => 'nullable|image',
            
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = User::find($id);
        $user->fill($request->all());

        if ($request->hasFile('avatar')) {
            if ($user->avatar != "avatars/default.png") {

            }
            
            Storage::delete('public/' . $user->avatar);

            $user->avatar = Str::of($request->avatar->store('public/avatars'))->after('public/');
        }
        
        if ($request->filled('current_password')) {
            // if (Hash::check($request->password, $request->user()->password))
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
            }
        }

        $user->save();

        return redirect(route('admin.profile'))->with('success', 'A profile was updated.');
    }
}
