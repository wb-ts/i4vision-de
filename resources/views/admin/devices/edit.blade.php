@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __ ('backend.devices')}}/{{ __ ('backend.edit')}}</div>

                <div class="card-body">
                    <form method="POST" id="device_edit" action="{{ url('admin/devices/' . $device->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row">
                            <label for="device_code" class="col-md-4 col-form-label text-md-right">{{ __('backend.code') }}</label>

                            <div class="col-md-4">
                                <input id="device_code" type="text" class="form-control @error('device_code') is-invalid @enderror" name="device_code" value="{{ $device->device_code }}" required autocomplete="device_code" autofocus placeholder="Code">
                            </div>
							<label for="enabled" class="col-form-label text-md-right col-md-1">{{ __('backend.active') }}?</label>
							<label class="switch" >
								<input type="checkbox" name="enabled" value="{{$device->enabled}}" id="enabled" @if ($device->enabled == 1) checked @endif >
								<span class="slider round"></span>
							</label>
                        </div>
						@php
							$is_disabled = "";$is_admin="";
							if (auth()->user()->type == "super_admin"){
								$is_disabled = "disabled";
								$is_admin = "hidden";	
							}
							
						@endphp
						<div class="form-group row">
							<label for="description" class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>
							<div class="col-md-6">
								<input type="text" id="description" name="description" {{ $is_disabled }} type="text" class="form-control" autofocus value="{{ $device->description }}"></input>
							</div>
						</div>
						@if (Auth()->user()->type == "super_admin")
							<div class="form-group row">
								<label for="client_id" class="col-md-4 col-form-label text-md-right">{{ __('backend.client') }}</label>

								<div class="col-md-6">
									
									<select class="form-control" @if(auth()->user()->type != "super_admin") @if (!empty($device->client_id) && $device->client_id != auth()->user()->client_id) disabled @endif @endif id="client_id" name="client_id">
										<option>Select Client</option>
										@foreach ($clients as $client)
										<option value="{{ $client->id }}" @if ($device->client_id == $client->id) selected @endif>{{ $client->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						@endif
						<div class="form-group row">
							<label for="timestamp_registered" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.first_register')}}</label>
							<div class="col-md-6">
								<input id="timestamp_registered" name="timestamp_registered" type="text" disabled class="form-control" value="{{ $device->timestamp_registered }}" autofocus>
							</div>
						</div>                        
						<div class="form-group row">
							<label for="timestamp_last_register" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.last_register')}}</label>
							<div class="col-md-6">
								<input id="timestamp_last_register" name="timestamp_last_register" type="text" disabled class="form-control" value="{{ $device->timestamp_last_register}}" autofocus>
							</div>
						</div>  
						@if (Auth()->user()->type == "super_admin")
                        <div class="form-group row">
                            <label for="timestamp_last_setup" class="col-md-4 col-form-label text-md-right">{{ __('backend.last_setup') }}</label>

                            <div class="col-md-6">
                                <input id="timestamp_last_setup" type="text" disabled class="form-control @error('timestamp_last_setup') is-invalid @enderror" name="timestamp_last_setup" value="{{ $device->timestamp_last_setup }}" autocomplete="timestamp_last_setup" autofocus>
                            </div>
                        </div>
						@endif
						<div class="form-group row">
                            <label for="timestamp_last_accessed" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.last_access')}}</label>

                            <div class="col-md-4">
                                <input id="timestamp_last_accessed" type="text" disabled class="form-control @error('timestamp_last_accessed') is-invalid @enderror" name="timestamp_last_accessed" value="{{ $device->timestamp_last_accessed }}" autocomplete="timestamp_last_accessed" autofocus>
                            </div>
							<div class="col-md-2">
								<div class="form-control">
									@php
										$time = new Datetime;
										$time->format('Y-m-d H:i:s');
										$laTimezone = new DateTimeZone('CET');
										$time -> setTimeZone( $laTimezone );
											$mins = intval((strtotime($time->format('Y-m-d H:i:s')) - strtotime($device->timestamp_last_accessed))/60);
											if ($mins <= 1 ){ echo ($mins. "min ago"); }
											else if ( $mins < 60 ) { echo ($mins." mins ago"); }
											else if( $mins < 60*24) { echo (intval($mins/60) . " hours ago"); }
											else if( $mins < 60*24*7) { echo (intval($mins/60/24) ." days ago"); }
											else if( $mins < 60*24*30) { echo (intval($mins/60/24/7) ." weeks ago"); }
											else{ echo (intval($mins/60/24/30) ." months ago"); 
										}
									@endphp
								</div>
							</div>
                        </div>
						
						<div class="form-group row">
                            <label for="ip_address_of_last_access" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.ip_address_of_last_access')}}</label>
                            <div class="col-md-6">
                                <input id="ip_address_of_last_access" type="text" disabled class="form-control @error('device_down_time') is-invalid @enderror" value="{{ $device->ip_address_of_last_access }}" autofocus>
                            </div>
                        </div>

						
						
						<div class="row">
							<label for="up_down_time"  class="col-md-4 col-form-label text-md-right">{{ __ ('backend.device_up_down_time')}}</label>
							<div class="col-md-6 row" id= "up_down_time" name="up_down_time" style="margin-left:0px ;padding:0px">
								<div class="form-group col-md-6">
									<input id="device_up_time" name="device_up_time" {{ $is_disabled }} type="time" class="form-control" value="{{ $device->device_up_time }}" placeholder="Up Time" autofocu>
								</div>

								<div class="form-group col-md-6">
									<input id="device_down_time" name="device_down_time" {{ $is_disabled }} type="time" class="form-control" value="{{ $device->device_down_time }}" placeholder="Down Time" autofocus>
								</div>
							</div>
							
						</div>
							
						
							<div class="form-group row">
								<label for="device_heartbeat_minutes" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.device_heartbeat_minutes')}}</label>
								<div class="col-md-3">
									<input id="device_heartbeat_minutes" {{ $is_disabled }} name="device_heartbeat_minutes" type="text" class="form-control" value="{{ $device->device_heartbeat_minutes }}" autofocus>
								</div>
								<label for="force_restart_enabled" class="col-md-2 col-form-label text-md-right">{{ __ ('backend.force_restart')}}?</label>
								<label class="switch" >
									<input type="checkbox" name="force_restart_enabled" value='' id="force_restart_enabled" @if ($device->force_restart_enabled == 1) checked @endif >
									<span class="slider round"></span>
								</label>
							</div>
							<div class="form-group row {{$is_admin}}">
								<label for="show_at_frontend" class="col-md-4 col-form-label text-md-right">{{ __ ('backend.show_at_frontend')}}</label>
								<div class="col-md-6">
									<select name="show_at_frontend"  id="show_at_frontend" class="form-control">
										<option value="">Select Type</option>
										<option @if ($device->show_at_frontend == "App\Image") selected @endif value="App\Image">{{ __('backend.images')}}</option>
										<option @if ($device->show_at_frontend == "App\Gallery") selected @endif value="App\Gallery">{{ __('backend.galleries')}}</option>
										<option @if ($device->show_at_frontend == "App\Site") selected @endif value="App\Site">{{ __('backend.sites')}}</option>
										<option @if ($device->show_at_frontend == "App\Flow") selected @endif value="App\Flow">{{ __('Flow')}}</option>
										<option @if ($device->show_at_frontend == "App\Schedule") selected @endif value="App\Schedule">{{ __('backend.schedules')}}</option>
										<option @if ($device->show_at_frontend == "Free") selected @endif value="Free">Free</option>
									</select>
								</div>
							</div>
							<div class="form-group row {{$is_admin}}">
								<label for="frontend_refer" class="col-md-4 col-form-label text-md-right">{{ __('backend.frontend_refer')}}</label>
								<div class="col-md-6">
									<div id="frontend_refer" >
										<input type="text" id="frontend_refer_name"  value="{{$device->frontend_refer}}"  class="form-control">
									</div>
                    			</div>
							</div>
							<div class="form-group row {{$is_admin}}">
                                    <label for="frontend_layout" class="col-md-4 col-form-label text-md-right">{{ __('backend.layout')}}</label>

                                    <div class="col-md-6">
                                        <input id="frontend_layout" type="text" class="form-control @error('frontend_layout') is-invalid @enderror" name="frontend_layout" value="{{ $device->frontend_layout }}" autocomplete="frontend_layout" autofocus placeholder="Frontend Layout">
                                    </div>
                                </div>
							@if (Auth()->user()->type == "super_admin")
							<div class="form-group row">
								<label for="configuration" class="col-md-4 col-form-label text-md-right">{{ __('Setup') }}</label>
								<div class="col-md-6">
									<textarea id="configuration"  name="configuration" style="height:100px" type="text" class="form-control" autofocus>{{ $device->configuration }}</textarea>
								</div>
							</div>
							@endif

                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.devices') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                    <button class="btn btn-primary">{{ __('backend.save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/devices/index.js') }}"></script>
@endpush