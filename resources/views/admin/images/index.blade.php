@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.images') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/images/create') }}" class="btn btn-primary">{{ __('backend.create') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no') }}</th>
                                <th>{{ __('backend.name') }}</th>
                                <th>{{ __('backend.image') }}</th>
                                <th>{{ __('backend.description') }}</th>
                                <th>{{ __('backend.action') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($images)
                                @foreach ($images as $image)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $image->name }}</td>
                                        <td>
                                            <img src="{{ asset('storage') . '/' . $image->url }}" class="rounded table-image-size" alt="{{ $image->url }}">
                                        </td>
                                        <td>{{ $image->description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/images/' . $image->id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $image->id }}" class="btn btn-danger btn-image-delete"><i class="fa fa-trash-o"></i></button>
                                              <a href="@php echo("http://front.i4vision.de/?clientname=" .Auth::user()->client->name."&"."image=".$image->name) @endphp"  target="_blank" class="btn btn-primary"><i class="fa fa-desktop"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                              @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="image_delete_form" data-current_url="{{ url('admin/images') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')

    <script type="text/javascript">
$(document).ready(function() {
	$('.btn-image-delete').click(function() {
        var selectedId = $(this).data("id");
        bootbox.confirm({
            message: '{{ __("backend.con_message")}}',
            buttons: {
                confirm: {
                    label: '{{ __("backend.con_yes")}}',
                    className: 'btn-success'
                },
                cancel: {
                    label: '{{ __("backend.con_no")}}',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $("#image_delete_form").attr("action", $('#image_delete_form').data('current_url') + "/" + selectedId);
                    $("#image_delete_form").submit();
                }
            }
        });
    });
    
});
    </script>

@endpush
