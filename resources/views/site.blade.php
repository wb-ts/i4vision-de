@extends('layouts.app')

@section('content')
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      @if (isset($site) && !empty($site))
        <div style="height: 100vh;" class="item active">
          <iframe style="width: 100%; height: 100%;" src="{{ $site->url }}"></iframe>
        </div>
      @endif
    </div>
@endsection