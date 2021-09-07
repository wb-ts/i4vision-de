@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.users')}}/<i class="fa fa-edit"></i></div>

                <div class="card-body">
                    <form method="POST" action="{{ url('admin/users/' . $user->id) }}">
                        @csrf
                        @method('PUT')
                        
                        

<!-- first name -->
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('backend.first_name')}}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>
                            </div>
                        </div>
<!-- last name -->
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('backend.last_name')}}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>
                            </div>
                        </div>

<!-- username -->
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('backend.username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('backend.email_address')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                            </div>
                        </div>
<!-- phone number -->
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('backend.phone_number')}}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus>
                            </div>
                        </div>
<!-- gender -->
                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('backend.gender') }}</label>

                            <div class="col-md-6">

                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" autocomplete="gender" autofocus>
                                    <option @if ($user->gender == "0") {{ "selected" }} @endif value="0">{{ __('backend.male')}}</option>
                                    <option @if ($user->gender == "1") {{ "selected" }} @endif value="1">{{ __('backend.female')}}</option>
                                    <option @if ($user->gender == "2") {{ "selected" }} @endif value="2">{{ __('backend.other')}}</option>
                                </select>
                            </div>
                        </div>
<!-- status -->
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('backend.status') }}</label>

                            <div class="col-md-6">

                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" autocomplete="status" autofocus>
                                    <option @if ($user->status == "0") {{ "selected" }} @endif value="0">{{ __('backend.in_active')}}</option>
                                    <option @if ($user->status == "1") {{ "selected" }} @endif value="1">{{ __('backend.active')}}</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('backend.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('backend.confirm_password')}}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('admin.users') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                <a href="{{ url()->current() }}" class="btn btn-default">Reset</a>
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

