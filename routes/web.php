<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'APIDevicesController@index');
// Route::get('/admin/', 'Admin\UsersController@index');

 // App\Http\Controllers\ 

Route::prefix('admin')->namespace('Admin')->group(function () {


	Route::get('/', 'HomeController@index');
	Route::get('/db_backup', 'BackupController@db_backup');
	
	Route::name('admin.')->group(function () {
		Auth::routes();
	});

	Route::get('/home', 'HomeController@index')->name('admin.home');


	Route::get('/lang/home', 'LangController@index');
	Route::get('/lang/change', 'LangController@change')->name('changeLang');	


	// users
	Route::get('/users', 'UsersController@index')->name('admin.users');
	Route::get('/users/create', 'UsersController@create')->name('admin.users.create');
	Route::post('/users', 'UsersController@store')->name('admin.users');
	Route::get('/users/{id}/edit', 'UsersController@edit')->name('admin.users.edit');
	Route::put('/users/{id}', 'UsersController@update');
	Route::delete('/users/{id}', 'UsersController@destroy');

	// images
	Route::get('/images', 'ImagesController@index')->name('admin.images');
	Route::get('/images/create', 'ImagesController@create')->name('admin.images.create');
	Route::post('/images', 'ImagesController@store')->name('admin.images');
	Route::get('/images/{id}/edit', 'ImagesController@edit')->name('admin.images.edit');
	Route::put('/images/{id}', 'ImagesController@update');
	Route::delete('/images/{id}', 'ImagesController@destroy');

	// flows
	Route::get('/flows', 'FlowsController@index')->name('admin.flows');
	Route::get('/flows/create', 'FlowsController@create')->name('admin.flows.create');
	Route::post('/flows', 'FlowsController@store')->name('admin.flows');
	Route::post('/flows/clone', 'FlowsController@clone')->name('admin.flows.clone');
	Route::get('/flows/{id}/edit/is_flow_active/{is_flow_active?}', 'FlowsController@edit')->name('admin.flows.edit');
	Route::put('/flows/{id}', 'FlowsController@update');
	Route::delete('/flows/{id}', 'FlowsController@destroy');

	// flow entries
	Route::get('/flows/{flow_id}/get_flow_entriable_names', 'FlowsController@get_flow_entriable_names');
	Route::post('/flows/{flow_id}/flow_entry_store/{is_flow_active}', 'FlowsController@flow_entry_store');
	Route::post('/flows/{flow_id}/flow_entry_clone/{is_flow_active}', 'FlowsController@flow_entry_clone');
	Route::post('/flows/{id}/flow_entry_move/{is_flow_active}', 'FlowsController@flow_entry_move');
	Route::get('/flows/{flow_id}/get_flow_entry/{id}', 'FlowsController@get_flow_entry');
	Route::post('/flows/{flow_id}/flow_entry_update/{flow_entry_id}/{is_flow_active}', 'FlowsController@flow_entry_update');
	Route::delete('/flows/{flow_id}/{flow_entry_id}', 'FlowsController@flow_entry_delete');


	// galleries
	Route::get('/galleries', 'GalleriesController@index')->name('admin.galleries');
	Route::get('/galleries/create', 'GalleriesController@create')->name('admin.galleries.create');
	Route::post('/galleries', 'GalleriesController@store')->name('admin.galleries');
	Route::post('/galleries/clone', 'GalleriesController@clone')->name('admin.galleries.clone');
	Route::get('/galleries/{id}/edit', 'GalleriesController@edit')->name('admin.galleries.edit');
	Route::put('/galleries/{id}', 'GalleriesController@update');
	Route::delete('/galleries/{id}', 'GalleriesController@destroy');

	// sites
	Route::get('/sites', 'SitesController@index')->name('admin.sites');
	Route::get('/sites/create', 'SitesController@create')->name('admin.sites.create');
	Route::post('/sites', 'SitesController@store')->name('admin.sites');
	Route::post('/sites/clone', 'SitesController@clone')->name('admin.sites.clone');
	Route::get('/sites/{id}/edit', 'SitesController@edit')->name('admin.sites.edit');
	Route::put('/sites/{id}', 'SitesController@update');
	Route::delete('/sites/{id}', 'SitesController@destroy');

	// schedules
	Route::get('/schedules', 'SchedulesController@index')->name('admin.schedules');
	Route::get('/schedules/create', 'SchedulesController@create')->name('admin.schedules.create');
	Route::post('/schedules', 'SchedulesController@store')->name('admin.schedules');
	Route::post('/schedules/clone', 'SchedulesController@clone')->name('admin.schedules.clone');
	Route::get('/schedules/{id}/edit/is_schedule_active/{is_schedule_active?}', 'SchedulesController@edit')->name('admin.schedules.edit');
	Route::put('/schedules/{id}', 'SchedulesController@update');
	Route::delete('/schedules/{id}', 'SchedulesController@destroy');

	// schedule entries
	Route::get('/schedules/{schedule_id}/get_schedule_entriable_id', 'SchedulesController@get_schedule_entriable_id');
	Route::post('/schedules/{schedule_id}/schedule_entry_store/{is_schedule_active}', 'SchedulesController@schedule_entry_store');
	Route::post('/schedules/{schedule_id}/schedule_entry_clone/{is_schedule_active}', 'SchedulesController@schedule_entry_clone');
	Route::post('/schedules/{id}/schedule_entry_move/{is_schedule_active}', 'SchedulesController@schedule_entry_move');
	Route::get('/schedules/{schedule_id}/get_schedule_entry/{id}', 'SchedulesController@get_schedule_entry');
	Route::post('/schedules/{schedule_id}/schedule_entry_update/{schedule_entry_id}/{is_schedule_active}', 'SchedulesController@schedule_entry_update');
	Route::delete('/schedules/{schedule_id}/{schedule_entry_id}', 'SchedulesController@schedule_entry_delete');

	// super admin menus

	// clients
	Route::get('/clients', 'ClientsController@index')->name('admin.clients');
	Route::get('/clients/create', 'ClientsController@create')->name('admin.clients.create');
	Route::post('/clients', 'ClientsController@store')->name('admin.clients');
	Route::get('/clients/{id}/edit/is_users_of_client_tab_active/{is_users_of_client_tab_active?}', 'ClientsController@edit')->name('admin.clients.edit');
	Route::put('/clients/{id}', 'ClientsController@update');
	Route::delete('/clients/{id}', 'ClientsController@destroy');
	
	Route::post('/clients/{id}/store_user_of_client/{is_users_of_client_tab_active}', 'ClientsController@store_user_of_client');
	Route::post('/clients/{id}/update_user_of_client/{user_id}/{is_users_of_client_tab_active}', 'ClientsController@update_user_of_client');
	Route::get('/clients/{client_id}/get_user/{user_id}', 'ClientsController@get_user');
	Route::delete('/clients/{client_id}/{user_id}', 'ClientsController@destroy_user');

	// devices
	Route::get('/devices/{id}/get_frontend_refers', 'DevicesController@get_frontend_refers');
	Route::get('/devices/{id}/get_device', 'DevicesController@get_device');

	Route::get('/devices', 'DevicesController@index')->name('admin.devices');
	//Route::get('/devices/create', 'DevicesController@create')->name('admin.devices.create');
	// Route::post('/devices', 'DevicesController@store')->name('admin.devices');
	Route::get('/devices/{id}/edit', 'DevicesController@edit')->name('admin.devices.edit');
	Route::put('/devices/{id}', 'DevicesController@update');
	Route::delete('/devices/{id}', 'DevicesController@destroy');

	// sync google images
	Route::post('/sync_google_image', 'SyncGoogleImagesController@save');

	// profile
	Route::get('/profile', 'ProfileController@index')->name('admin.profile');
	Route::put('/profile/{id}', 'ProfileController@update');
});