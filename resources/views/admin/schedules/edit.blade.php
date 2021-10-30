@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link @if($is_schedule_active) active @endif" id="schedule_tab"
                        href="#schedule">{{ __('backend.schedule') }} {{ __('backend.entries') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!$is_schedule_active) active @endif" href="#schedule_entries">{{ __('backend.schedule') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="schedule_entries" class="container tab-pane @if($is_schedule_active) fade @else active @endif"><br>
                    <div class="card">
                        <div class="card-header">{{ __('backend.schedules') }}/{{ __('backend.edit') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('admin/schedules/' . $schedule->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $schedule->name }}" required autocomplete="name" autofocus
                                            placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description"
                                        class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="description" type="description"
                                            class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description">{{ $schedule->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="layout"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Layout') }}</label>

                                    <div class="col-md-6">
                                        <input id="layout" type="text"
                                            class="form-control @error('layout') is-invalid @enderror" name="layout" value="{{ $schedule->layout }}" autocomplete="layout" autofocus placeholder="Layout">
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a href="{{ route('admin.schedules') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                        <button class="btn btn-primary">{{ __('backend.save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="schedule" class="container tab-pane @if($is_schedule_active) active @else fade @endif">
                    <br>
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a id="btn_show_schedule_entry_modal" href="#" data-toggle="modal"  data-target="#myModal" class="btn btn-primary">{{ __('backend.create') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                                <tr>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.type') }}</th>
                                    <th>{{ __('backend.line') }} 1</th>
                                    <th>{{ __('backend.line') }} 2</th>
                                    <th>{{ __('backend.line') }} 3</th>
                                    <th>{{ __('backend.run_from')}}</th>
                                    <th>{{ __('backend.run_to')}}</th>
                                    <th>{{ __('backend.dates')}}</th>
                                    <th>{{ __('backend.image') }}</th>

                                    <th>{{ __('backend.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($schedule->schedule_entries)
                                @foreach ($schedule->schedule_entries as $key => $schedule_entry)
                                <tr>
                                    <td>{{ date("Y.m.d", strtotime($schedule_entry->date) )}}</td>
                                    <td>{{ $schedule_entry->time }}</td>
                                    <td>{{ $schedule_entry->schedule_entriable_id }}</td>
                                    <td>{{ $schedule_entry->line1 }}</td>
                                    <td>{{ $schedule_entry->line2 }}</td>
                                    <td>{{ $schedule_entry->line3 }}</td>

                                    <td>{{ $schedule_entry->run_from }}</td>
                                    <td>{{ $schedule_entry->run_to }}</td>
                                    <td>@php echo( str_replace( ',','<br>', $schedule_entry->dates )) @endphp</td>
                                    <td>
                                        @if ($schedule_entry->image_id)
                                            <img src="{{ asset('storage') . '/' . $images[$schedule_entry->image_id]->url }}" class="rounded table-image-size" alt="{{ $images[$schedule_entry->image_id]->url }}">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" data-id="{{ $schedule_entry->id }}" data-toggle="modal"
                                                data-target="#myModal"
                                                class="btn btn-primary btn-schedule-entry-edit"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-id="{{ $schedule_entry->id }}"
                                                class="btn btn-danger btn-schedule-entry-delete"> <i class="fa fa-trash-o"></i> </button>
                                            <button type="button" data-schedule_entry="{{ $schedule_entry }}"
                                                class="btn btn-success btn-schedule-entry-clone"><i class="fa fa-clone"></i></button>
                                            <a href="#" data-schedule_entry="{{ $schedule_entry }}" data-url="{{ url('admin/schedules/' . $schedule_entry->id .'/schedule_entry_move/'.$is_schedule_active )}}" data-toggle="modal"
                                                data-target="#myMoveModal" class="btn btn-warning btn-schedule-entry-move"><i class="fas fa-truck-moving"></i></a>
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

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('backend.schedule') }} {{ __('backend.entry') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form id="schedule_entry_form" method="POST" action="{{ url('admin/schedules/' . $schedule->id) }}" enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">

                    <!-- date -->
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('backend.date') }}</label>

                        <div class="col-md-6">
                            <input id="date" type="text" class="form-control @error('date') is-invalid @enderror datepicker" name="date" value="{{ $schedule->date }}" required autocomplete="date" placeholder="Date" >
                        </div>
                    </div>
                    <!-- date -->
                   <div class="form-group row">
                        <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('backend.time') }}</label>

                        <div class="col-md-6">
                            <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ $schedule->time }}" required autocomplete="time" placeholder="Time">
                        </div>
                    </div>
                    <!-- type -->
                    <div class="form-group row">
                        <label for="schedule_entriable_id" class="col-md-4 col-form-label text-md-right">{{ __('backend.type') }}</label>

                        <div class="col-md-6">
                            <select name="schedule_entriable_id" id="schedule_entriable_id" class="form-control @error('schedule') is-invalid @enderror" required autocomplete="schedule_entriable_id">
                                <option value="">Select Type</option>
                                <option value="kids">{{ __('backend.kids')}}</option>
                                <option value="adults">{{ __('backend.adults')}}</option>
                                <option value="general">{{ __('backend.general')}} </option>
                            </select>
                        </div>
                    </div>
                    <!-- line1 -->
                    <div class="form-group row">
                        <label for="line1" class="col-md-4 col-form-label text-md-right">{{ __('backend.line')}}1</label>

                        <div class="col-md-6">
                            <input id="line1" type="text" class="form-control @error('line1') is-invalid @enderror" name="line1" value="{{ $schedule->line1 }}" required autocomplete="line1"  placeholder="Line1">
                        </div>
                    </div>

                    <!-- line2 -->
                    <div class="form-group row">
                        <label for="line2" class="col-md-4 col-form-label text-md-right">{{ __('backend.line')}}2</label>

                        <div class="col-md-6">
                            <input id="line2" type="text" class="form-control @error('line1') is-invalid @enderror" name="line2" value="{{ $schedule->line2 }}" required autocomplete="line2" placeholder="Line2" >
                        </div>
                    </div>
                    <!-- line3 -->
                    <div class="form-group row">
                        <label for="line3" class="col-md-4 col-form-label text-md-right">{{ __('backend.line')}}3</label>

                        <div class="col-md-6">
                            <input id="line3" type="text" class="form-control @error('line1') is-invalid @enderror" name="line3" value="{{ $schedule->line3 }}" required autocomplete="line3" placeholder="Line3">
                        </div>
                    </div>
                    <!-- image -->
                    <div class="form-group row">
                        <label for="run_from" class="col-md-4 col-form-label text-md-right">{{ __('backend.run_from') }}</label>

                        <div class="col-md-6">
                            <input id="run_from" type="text" class="form-control @error('type') is-invalid @enderror datepicker" name="run_from" value="" required autocomplete="run_from" autofocus placeholder="Run From">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="run_to" class="col-md-4 col-form-label text-md-right">{{ __('backend.run_to') }}</label>

                        <div class="col-md-6">
                            <input id="run_to" type="text" class="form-control @error('type') is-invalid @enderror datepicker" name="run_to" value="" required autocomplete="run_to" autofocus placeholder="Run To">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dates" class="col-md-4 col-form-label text-md-right">{{ __('backend.dates') }}</label>

                        <div class="col-md-6">
                            <input id="dates" type="text" class="form-control @error('type') is-invalid @enderror multidatepicker" name="dates" value="" required autocomplete="dates" autofocus placeholder="Dates">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image_id" class="col-md-4 col-form-label text-md-right">{{ __('backend.image') }}</label>

                        <div class="col-md-6">
                            <select name="image_id" id="image_id" class="form-control">
                                <option value="">Select Image</option>
                                @foreach ($images as $key => $image)
                                    <option @if ($image->id == $schedule->image_id) selected @endif value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close')}}</button>
                    <button type="button" id="btn_schedule_entry_save" class="btn btn-primary">{{ __('backend.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="myMoveModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="schedule_entry_move_form" method="POST" >
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('backend.schedule') }} {{ __('backend.move') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="model-body">
                    <div style="text-align: center;margin-top:10px"><p > &nbsp;{{ __('backend.where')}}</p></div>
                    <div class="form-group row">
                        <select name="schedule_id" class="form-control" style="width:50%;margin-left:25%" id="move_schedule_id">
                            @foreach ($schedule_list as $each_schedule)
                            @if ($each_schedule->id!=$schedule->id)
                            <option value="{{$each_schedule->id}}">{{$each_schedule->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close')}}</button>
                    <button type="button" id="btn_schedule_entry_move"  data-dismiss="modal" class="btn btn-primary">{{ __('backend.move')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<form id="schedule_entry_delete_form" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="schedule_entry_clone_form" method="POST" action="{{ url('admin/schedules/' . $schedule->id .'/schedule_entry_clone/'.$is_schedule_active )}}">
    @csrf
</form>
@endsection

@push('scripts')
<script>

$(document).ready(function(){
    var schedule_edit_url = $("#schedule_entry_form").attr("action");


    $('.datepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true
    });

    $('.multidatepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true,
        multidate: true
    });

    $("#btn_schedule_entry_save").click(function() {
        var formData = $("#schedule_entry_form").serializeArray();

        var schedule_tab = 0;
        if ($("#schedule_tab").hasClass('active')) {
            schedule_tab = 1;
        }
        if ($("#schedule_entriable_id").val() == "Select Type"){
            alert("Please select Type!");
            return;
        } 
        var currentAction = $('#schedule_entry_form').attr('action');
        $('#schedule_entry_form').attr('action', currentAction + '/' + schedule_tab);
        $('#schedule_entry_form').submit();
    });

    $(".btn-schedule-entry-edit").click(function () {

        $.ajax({
            url: schedule_edit_url + '/get_schedule_entry/' + $(this).data('id'),
            method: 'GET',
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                $("#date").val(data.schedule_entry.date);
                $("#time").val(data.schedule_entry.time);

                console.log(data.schedule_entry.schedule_entriable_id);
                var optionHtml = "<option>Select Type</option>";
                if( data.schedule_entry.schedule_entriable_id == "kids" ) {
                    optionHtml +="<option value='kids' selected>Kids</option>";
                    optionHtml +="<option value='adults'>Adults</option>";
                    optionHtml +="<option value='general'>General</option>";
                }
                if( data.schedule_entry.schedule_entriable_id == "adults") {
                    optionHtml +="<option value='kids'>Kids</option>";
                    optionHtml +="<option value='adults' selected>Adults</option>";
                    optionHtml +="<option value='general'>General</option>";
                }
                if( data.schedule_entry.schedule_entriable_id == "general") {
                    optionHtml +="<option value='kids'>Kids</option>";
                    optionHtml +="<option value='adults'>Adults</option>";
                    optionHtml +="<option value='general' Selected>general</option>";
                }
                console.log(optionHtml);
                $("#schedule_entriable_id").html(optionHtml);
                $("#line1").val(data.schedule_entry.line1);
                $("#line2").val(data.schedule_entry.line2);
                $("#line3").val(data.schedule_entry.line3);
                $("#time").val(data.schedule_entry.time);
                $("#run_from").val(data.schedule_entry.run_from);
                $("#run_to").val(data.schedule_entry.run_to);
                $("#dates").val(data.schedule_entry.dates);

                $("#image_id").val(data.schedule_entry.image_id);


                $("#schedule_entry_form").attr('action', schedule_edit_url + "/schedule_entry_update/" + data.schedule_entry.id);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $("#btn_show_schedule_entry_modal").click(function () {
        $("#schedule_entry_form").attr('action', schedule_edit_url + "/schedule_entry_store")
    });

    $('.btn-schedule-entry-delete').click(function() {
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
                    $("#schedule_entry_delete_form").attr("action", schedule_edit_url + "/" + selectedId);
                    $("#schedule_entry_delete_form").submit();
                }
            }
        });
    });
    $('.btn-schedule-entry-clone').click(function() {
        var selectSchedule = $(this).data("schedule_entry");
        console.log(selectSchedule);
        var data = $("#schedule_entry_clone_form").serialize();
        data +="&date="+selectSchedule['date']+"&time="+selectSchedule['time']+"&line1="+selectSchedule['line1']+"&line2="+selectSchedule['line2']+"&line3="+selectSchedule['line3']+"&image_id="+selectSchedule['image_id']+"&schedule_entriable_id="+selectSchedule['schedule_entriable_id'];

        $.ajax({
            type: 'POST',
            url: $("#schedule_entry_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="is_schedule_active";
            }
        })
    });
    $('#btn_schedule_entry_move').click(function() {
        move_schedule_id = $('#move_schedule_id').val();
        selectSchedule = $(".btn-schedule-entry-move").data('schedule_entry');
        var data = $("#schedule_entry_move_form").serialize();

        console.log(data);
        $.ajax({
            type: 'POST',
            url: $(".btn-schedule-entry-move").data('url'),
            dataType: 'json',
            data: data ,
            success: function(data) {
                location.href="is_schedule_active";
            }
        })
    });
});

</script>
@endpush