@extends('admin.layouts.app')

@section('content')

<?php header("Access-Control-Allow-Origin: *"); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('backend.galleries') }}/{{ __('backend.create') }}</div>

                <div class="card-body">
                    <form method="POST" id="gallery_form" data-current_url="{{ url('admin/galleries') }}" method="POST" action="{{ route('admin.galleries') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="clearfix">
                            <div class="row float-right ">
                                <div class="form-group col-md-12">
                                    <a href="{{ route('admin.galleries') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                    <button class="btn btn-primary">{{ __('backend.save')}}</button>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required autocomplete="name" autofocus placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="google_link" class="col-md-4 col-form-label text-md-right">{{ __('backend.google_link') }}</label>

                            <div class="col-md-6">
                                <input id="google_link" type="text" class="form-control @error('google_link') is-invalid @enderror" name="google_link" value="" autocomplete="google_link" autofocus required placeholder="Google Link">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description"  placeholder="Description"></textarea>
                            </div>
                        </div>

                        
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.galleries') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                    <button type="button" id="save_btn" class="btn btn-primary ">{{ __('backend.save')}}</button>
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
    <script type="text/javascript" src="{{ asset('js/jquery.googleslides.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/galleries/form.js') }}"></script>
@endpush