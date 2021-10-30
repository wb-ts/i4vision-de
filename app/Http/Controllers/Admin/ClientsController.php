<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Client;
use App\User;

class ClientsController extends Controller
{
    const PAGE_NAME = "clients";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkforsuperadmin');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clients = Client::orderBy('name')->get();

        return view('admin/clients/index', ['clients' => $clients, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/clients/create', ['page_name' => self::PAGE_NAME]);
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
            'name' => ['required', 'string', 'max:255', 'unique:clients'],
            'status' => 'required|boolean|max:255',
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->address = $request->address;
		$client->supervisor_email = $request->supervisor_email;

        $client->status = $request->status;
        
        $client->save();

        return redirect(route('admin.clients'))->with('success', 'A new client was created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $is_users_of_client_active = 0)
    {
        $client = Client::find($id);
        
        if (empty($client)) {
            return redirect(route('admin.clients'))->with('warning', 'warning.');
        }

        return view('admin/clients/edit', ['client' => $client, 'is_users_of_client_active' => $is_users_of_client_active, 'page_name' => self::PAGE_NAME]);
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
                            Rule::unique('clients')->ignore($id),
                        ],
            'status' => 'required|boolean|max:255',
        ]);


        $client = Client::find($id);

        $client->name = $request->name;
        $client->description = $request->description;
        $client->address = $request->address;
        $client->status = $request->status;
		$client->supervisor_email = $request->supervisor_email;

        $client->save();
        // if ($request->password) {
        //     $client->password = Hash::make($request->password);
        // }

        return redirect(url('admin/clients/' . $id . '/edit/is_users_of_client_tab_active'))->with('success', 'A client was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return redirect(url('admin/clients'))->with('success', 'A client was deleted.');
    }
	
	public function store_user_of_client(Request $request, $client_id, $is_users_of_client_active) {
        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|string|max:255',
            'gender' => 'required|boolean|max:255',
            'status' => 'boolean|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        

        $user = new User($request->all());
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->type = 'admin';
        $user->client_id = $client_id;
        $user->save();

        return redirect(url('admin/clients/' . $client_id . '/edit/is_users_of_client_tab_active/' . $is_users_of_client_active))->with('success', 'A new user was created.');
    }

    public function get_user($client_id, $user_id) {
        return response()->json([
            'user' => User::find($user_id),
        ]);
    }


    public function update_user_of_client(Request $request, $client_id, $user_id, $is_users_of_client_active) {
        $validator = $request->validate([
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'username' => 'required|string|max:255',
            // 'email' => [
            //                 'required',
            //                 'string',
            //                 'email',
            //                 'max:255',
            //                 Rule::unique('users')->ignore($user_id),
            //             ],
            // 'phone' => 'required|string|max:255',
            // 'gender' => 'required|boolean|max:255',
            'status' => 'boolean|max:255',
        ]);
        $user = User::find($user_id);
        // $user = $user->fill($request->all());
        $user->status = $request->status;
        // $user->password = Hash::make($request->password);
        // $user->type = 'admin';
        $user->save();

        return redirect(url('admin/clients/' . $client_id . '/edit/is_users_of_client_tab_active/' . $is_users_of_client_active))->with('success', 'A user was updated.');
    }

    public function destroy_user($client_id, $user_id)
    {
        User::destroy($user_id);
        return redirect(url('admin/clients/' . $client_id . '/edit/is_users_of_client_tab_active'))->with('success', 'A user was deleted.');
    }
}
