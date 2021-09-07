@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.galleries') }}/{{ __('backend.edit') }}</div>

                <div class="card-body">
                    <form method="POST" id="gallery_form" action="{{ url('admin/galleries/' . $gallery->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- <div class="clearfix">
                            <div class="row float-right ">
                                <div class="form-group col-md-12">
                                    <a href="{{ route('admin.galleries') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                    <button class="btn btn-primary">{{ __('backend.save')}}</button>
                                </div>
                            </div>
                        </div>
 -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $gallery->name }}" required autocomplete="name" autofocus placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="google_link" class="col-md-4 col-form-label text-md-right">{{ __('backend.google_link') }}</label>

                            <div class="col-md-6">
                                <input id="google_link" type="text" class="form-control @error('google_link') is-invalid @enderror" name="google_link" value="{{ $gallery->google_link }}" autocomplete="google_link" autofocus placeholder="Google Link">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description"  placeholder="Description">{{ $gallery->description }}</textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.galleries') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                    <button type="button" id="save_btn" class="btn btn-primary disable-field">{{ __('backend.save')}}</button>
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