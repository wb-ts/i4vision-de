@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('backend.clients') }}/{{ __('backend.create')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.clients') }}" enctype="multipart/form-data">
                        @csrf
<!-- name -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                            </div>
                        </div>
<!-- Supervisor eMail -->
                        <div class="form-group row">
                            <label for="supervisor_email" class="col-md-4 col-form-label text-md-right">{{ __('backend.supervisor_eMail') }}</label>

                            <div class="col-md-6">
                                <input id="supervisor_email" type="email" class="form-control @error('supervisor_email') is-invalid @enderror" name="supervisor_email" value="{{ old('supervisor_email') }}" required autocomplete="supervisor_email" autofocus placeholder="Supervisor_eMail">
                            </div>
                        </div>
<!-- description -->    
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Description"></textarea>
                            </div>
                        </div>

<!-- address -->
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('backend.address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus placeholder="Address">
                            </div>
                        </div>
<!-- status -->
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('backend.status') }}</label>

                            <div class="col-md-6">

                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" autocomplete="status" autofocus>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.clients') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
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
