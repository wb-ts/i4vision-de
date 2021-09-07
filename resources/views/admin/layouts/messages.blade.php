<?php
    // alert(message) contexts
    $contexts = [
        'success',
        'info',
        'warning',
        'danger',
    ];
?>

<!-- validation error messages(alerts) -->
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ __($error) }}
        </div>
    @endforeach
@endif


<!-- success, info, warning, danger messages -->
@foreach ($contexts as $context)
    @if (session($context))
        <div class="alert alert-{{ $context }} alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ __(session($context)) }}
        </div>
    @endif
@endforeach
