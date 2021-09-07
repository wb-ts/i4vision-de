@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.schedules') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/schedules/create') }}" class="btn btn-primary">{{ __('backend.create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no')}}</th>
                                <th>{{ __('backend.name')}}</th>
                                <th>{{ __('backend.description')}}</th>
                                <th>{{ __('backend.layout')}}</th>
                                <th>{{ __('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($schedules)
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $schedule->name }}</td>
                                        <td>{{ $schedule->description }}</td>
                                        <td>{{ $schedule->layout }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/schedules/' . $schedule->id . '/edit/is_schedule_active') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $schedule->id }}" class="btn btn-danger btn-schedule-delete"><i class="fa fa-trash-o"></i></button>
                                              <button type="button" data-schedule="{{ $schedule }}"  class="btn btn-success btn-schedule-clone"><i class="fa fa-clone"></i></button>
                                              <a href="@php echo("/?clientname=" .Auth::user()->client->name."&"."schedule=".$schedule->name) @endphp"  target="_blank" class="btn btn-primary"><i class="fa fa-desktop"></i></a>
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

<form id="schedule_delete_form" data-current_url="{{ url('admin/schedules') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="schedule_clone_form" data-current_url="{{ url('admin/schedules/clone') }}" method="POST" action="{{route('admin.schedules.clone') }}">
    @csrf
</form>
@endsection

@push('scripts')
    <script>
$(document).ready(function () {
	$('.btn-schedule-delete').click(function() {
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
                    $("#schedule_delete_form").attr("action", $("#schedule_delete_form").data('current_url') + "/" + selectedId);
                    $("#schedule_delete_form").submit();
                }
            }
        });
    });
    
    $('.btn-schedule-clone').click(function() {
        var selectSchedule = $(this).data("schedule");
        console.log(selectSchedule);
        var data = $("#schedule_clone_form").serialize();
        data +="&name="+selectSchedule['name']+"_copy&description="+selectSchedule['description']+"&layout="+selectSchedule['layout'];
        
        $.ajax({
            type: 'POST',
            url: $("#schedule_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="schedules";
            }
        })
    });
})    
    </script>
@endpush
