@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Flows') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/flows/create') }}" class="btn btn-primary">{{ __('backend.create') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no') }}</th>
                                <th>{{ __('backend.name') }}</th>
                                <th>{{ __('backend.description') }}</th>
                                <th>{{ __('backend.layout') }}</th>
                                <th>{{ __('backend.action') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($flows)
                                @foreach ($flows as $flow)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $flow->name }}</td>
                                        <td>{{ $flow->description }}</td>
                                        <td>{{ $flow->layout }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/flows/' . $flow->id . '/edit/is_flow_active') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $flow->id }}" class="btn btn-danger btn-flow-delete"><i class="fa fa-trash-o"></i></button>
                                              <button type="button" data-flows="{{ $flow }}" class="btn btn-success btn-flow-clone"><i class="fa fa-clone"></i></button>
                                              <a href="@php echo("/?clientname=" .Auth::user()->client->name."&"."flow=".$flow->name."&design=".($flow->design?$flow->design:"flow")) @endphp"  class="btn btn-primary" target="_blank"><i class="fa fa-desktop"></i></a>
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

<form id="flow_delete_form" data-current_url="{{ url('admin/flows') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="flow_clone_form" data-current_url="{{ url('admin/flows/clone') }}" method="POST" action="{{ route('admin.flows.clone') }}">
    @csrf
</form>
@endsection

@push('scripts')
    
<script>
$(document).ready(function () {
	$('.btn-flow-delete').click(function() {
        var selectedId = $(this).data("id");
        bootbox.confirm({
            message: '{{ __("backend.con_message")}}',
            buttons: {
                confirm: {
                    label: '{{ __("backend.con_yes")}} ',
                    className: 'btn-success'
                },
                cancel: {
                    label: '{{ __("backend.con_no")}} ',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $("#flow_delete_form").attr("action", $("#flow_delete_form").data("current_url") + "/" + selectedId);
                    $("#flow_delete_form").submit();
                }
            }
        });
    });
    
    $('.btn-flow-clone').click(function() {
        var selectFlow = $(this).data("flows");
        console.log(selectFlow);
        var data = $("#flow_clone_form").serialize();
        data +="&name="+selectFlow['name']+"_copy&description="+selectFlow['description']+"&layout="+selectFlow['layout'];
        
        $.ajax({
            type: 'POST',
            url: $("#flow_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="flows";
            }
        })
    });
});
</script>
@endpush
