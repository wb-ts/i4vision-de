@extends('layouts.app')

@section('content')
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      @if (isset($image) && !empty($image))
        <div style="height: 100vh;" class="item active">
          <img style="width: 100%; height: 100%;" src="{{ asset('storage') . '/' . $image->url }}"></img>
        </div>
      @endif
    </div>
@endsection