@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link @if($is_flow_active) active @endif" id="flow_tab" href="#flow">{{ __('backend.flow')}} {{ __('backend.entries')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!$is_flow_active) active @endif" href="#flow_entries">{{ __('backend.flow')}} </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="flow_entries" class="container tab-pane @if($is_flow_active) fade @else active @endif"><br>
                    <div class="card">
                        <div class="card-header">{{ __('backend.flows')}}/{{ __('backend.edit') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('admin/flows/' . $flow->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $flow->name }}" required autocomplete="name" autofocus placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('backend.description') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description"  placeholder="Description">{{ $flow->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="layout" class="col-md-4 col-form-label text-md-right">{{ __('Layout') }}</label>

                                    <div class="col-md-6">
                                        <input id="layout" type="text" class="form-control @error('layout') is-invalid @enderror" name="layout" value="{{ $flow->layout }}" autocomplete="layout" autofocus placeholder="Layout">
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                            <a href="{{ route('admin.flows') }}" class="btn btn-danger">{{ __('backend.back')}}</a>
                                            <button class="btn btn-primary">{{ __('backend.save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="flow" class="container tab-pane @if($is_flow_active) active @else flow @endif"><br>
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a id="btn_show_flow_entry_modal" href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary">{{ __('backend.create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.sequence')}}</th>
                                <th>{{ __('backend.type')}}</th>
                                <th>{{ __('backend.name')}}</th>
                                <th>{{ __('backend.time_sec')}}</th>
                                <th>{{ __('backend.run_from')}}</th>
                                <th>{{ __('backend.run_to')}}</th>
                                <th>{{ __('backend.dates')}}</th>
                                <th>{{ __('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($flow->flow_entries)
                                @foreach ($flow->flow_entries as $flow_entry)
                                    <tr>
                                        <td>{{ $flow_entry->sequence }}</td>
                                        <td>{{ $flow_entry->flow_entriable_type }}</td>
                                        @if ($flow_entry->flow_entriable_type == "App\Schedule")
                                            <td>{{ $flow_entry->flow_entriable_id }}</td>
										@elseif ($flow_entry->flow_entriable_type == "App\Device")
											<td>{{ $flow_entry->flow_entriable->device_code }}</td>
                                        @else
                                            <td>{{ $flow_entry->flow_entriable->name }}</td>
                                        @endif
                                        <td>{{ $flow_entry->time }}</td>
                                        <td>{{ $flow_entry->run_from }}</td>
                                        <td>{{ $flow_entry->run_to }}</td>
                                        <td>@php echo( str_replace( ',','<br>', $flow_entry->dates )) @endphp</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="#" data-id="{{ $flow_entry->id }}" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-flow-entry-edit" ><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $flow_entry->id }}" class="btn btn-danger btn-flow-entry-delete"><i class="fa fa-trash-o"></i></button>
                                              <button type="button" data-flow_entry="{{ $flow_entry }}" class="btn btn-success btn-flow-entry-clone"><i class="fa fa-clone"></i></button>
                                              <a href="#" data-url="{{ url('admin/flows/' . $flow_entry->id .'/flow_entry_move/'.$is_flow_active )}}" data-toggle="modal"
                                                data-target="#myMoveModal" class="btn btn-warning btn-flow-entry-move"><i class="fas fa-truck-moving"></i></a>

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
          <h4 class="modal-title">{{ __('backend.flow')}} {{ __('backend.entry')}}</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>

        <form id="flow_entry_form" method="POST" action="{{ url('admin/flows/' . $flow->id) }}" enctype="multipart/form-data">
        @csrf
            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group row">
                    <label for="sequence" class="col-md-4 col-form-label text-md-right">{{ __('backend.sequence') }}</label>

                    <div class="col-md-6">
                        <input id="sequence" type="text" class="form-control @error('sequence') is-invalid @enderror" name="sequence" value="" required autocomplete="sequence" autofocus placeholder="Sequence">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flow_entriable_type" class="col-md-4 col-form-label text-md-right">{{ __('backend.type') }}</label>

                    <div class="col-md-6">
                        <select name="flow_entriable_type" id="flow_entriable_type" class="form-control">
                            <option>Select Type</option>
                            <option value="App\Image">{{ __('backend.images') }}</option>
                            <option value="App\Gallery">{{ __('backend.galleries') }}</option>
                            <option value="App\Site">{{ __('backend.sites') }}</option>
                            <option value="App\Schedule">{{ __('backend.schedules') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flow_entriable_id" class="col-md-4 col-form-label text-md-right">{{ __('backend.name') }}</label>

                    <div class="col-md-6">
                        <select name="flow_entriable_id" id="flow_entriable_id" class="form-control">
                            <option value="">Select Name</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('backend.time_sec') }}</label>

                    <div class="col-md-6">
                        <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="" required autocomplete="time" autofocus placeholder="Time(Sec)">
                    </div>
                </div>


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
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close')}}</button>
              <button type="button" id="btn_flow_entry_save" class="btn btn-primary">{{ __('backend.save')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
<div class="modal fade" id="myMoveModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="flow_entry_move_form" method="POST" >
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('backend.flow') }} {{ __('backend.move') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="model-body">
                <div style="text-align: center;margin-top:10px"><p > &nbsp;{{ __('backend.where')}}</p></div>
                    <div class="form-group row">
                        <select name="flow_id" class="form-control" style="width:50%;margin-left:25%" id="move_flow_id">
                            @foreach ($flow_list as $each_flow)
                            @if ($each_flow->id!=$flow->id)
                            <option value="{{$each_flow->id}}">{{$each_flow->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close')}}</button>
                    <button type="button" id="btn_flow_entry_move"  data-dismiss="modal" class="btn btn-primary">{{ __('backend.move')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<form id="flow_entry_delete_form" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="flow_entry_clone_form" method="POST" action="{{ url('admin/flows/' . $flow->id .'/flow_entry_clone/'.$is_flow_active )}}">
    @csrf
</form>
@endsection

@push('scripts')
    <script >
$(document).ready(function(){
    var flow_edit_url = $("#flow_entry_form").attr("action");

    $("#flow_entriable_type").change(function () {
        getEntriableNames($(this).val());
    });
    function getEntriableNames(type,id=""){
        var flow_entriable_type = type;
        
        $.ajax({

            url: flow_edit_url + '/get_flow_entriable_names',
            method: 'GET',
            dataType: 'json',
            data: {'flow_entriable_type': flow_entriable_type},
            success: function(data, textStatus, jqXHR) {
                var optionHtml = '<option value="">Select Name</option>';

                if (flow_entriable_type == 'App\\Schedule') {
                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        if (id == data.flow_entriable_names[i].name ) {
                            optionHtml += '<option value="' + data.flow_entriable_names[i].name + '" selected>' + data.flow_entriable_names[i].name + '</option>';
                        }
                        optionHtml += '<option value="' + data.flow_entriable_names[i].name + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                } else {

                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        if(id == data.flow_entriable_names[i].id) {
                            optionHtml += '<option value="' + data.flow_entriable_names[i].id + '" selected>' + data.flow_entriable_names[i].name + '</option>';
                        }
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                }

                $("#flow_entriable_id").html(optionHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    }
    $('.datepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true
    });

    $('.multidatepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true,
        multidate: true
    });

    $("#btn_flow_entry_save").click(function() {
        var formData = $("#flow_entry_form").serializeArray();

        var flow_tab = 0;
        if ($("#flow_tab").hasClass('active')) {
            flow_tab = 1;
        }
        var currentAction = $('#flow_entry_form').attr('action');
        $('#flow_entry_form').attr('action', currentAction + '/' + flow_tab);
        // console.log($('#flow_entry_form').attr('action'));
        $('#flow_entry_form').submit();
        
    });

    $(".btn-flow-entry-edit").click(function () {
        console.log("@@@@");
        $.ajax({

            url: flow_edit_url + '/get_flow_entry/' + $(this).data('id'),
            method: 'GET',
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {

                var optionHtml = '<option value="">Select Name</option>';

                if (data.flow_entry.flow_entriable_type == 'App\\Device') {
                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].device_code + '</option>';
                    }
                } else if (data.flow_entry.flow_entriable_type == 'App\\Schedule')
				{
					for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].name + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
				} else {

                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                }

                $("#flow_entriable_id").html(optionHtml);



                $("#sequence").val(data.flow_entry.sequence);
                $("#flow_entriable_type").val(data.flow_entry.flow_entriable_type);
                getEntriableNames(data.flow_entry.flow_entriable_type,data.flow_entry.flow_entriable_id);
                $("#time").val(data.flow_entry.time);
                $("#run_from").val(data.flow_entry.run_from);
                $("#run_to").val(data.flow_entry.run_to);
                $("#dates").val(data.flow_entry.dates);

                $("#flow_entry_form").attr('action', flow_edit_url + "/flow_entry_update/" + data.flow_entry.id);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $("#btn_show_flow_entry_modal").click(function () {
        $("#flow_entry_form").attr('action', flow_edit_url + "/flow_entry_store")
    });

    $('.btn-flow-entry-delete').click(function() {
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
                    $("#flow_entry_delete_form").attr("action", flow_edit_url + "/" + selectedId);
                    $("#flow_entry_delete_form").submit();
                }
            }
        });
    });
    $('.btn-flow-entry-clone').click(function() {
        var selectFlow = $(this).data("flow_entry");
        console.log(selectFlow);
        var data = $("#flow_entry_clone_form").serialize();
        for (const [key, value] of Object.entries(selectFlow)) {
            if(value === null) selectFlow[key] = '';
        }
         data +="&dates="+selectFlow['dates'].replaceAll('null', '-')+"&time="+selectFlow['time']+"&run_from="+selectFlow['run_from']+"&run_to="+selectFlow['run_to']+"&sequence="+(selectFlow['sequence']-100000)+"&flow_id="+selectFlow['flow_id']+"&flow_entriable_id="+selectFlow['flow_entriable_id']+"&flow_entriable_type="+selectFlow['flow_entriable_type'];
        // alert(data);
        $.ajax({
            type: 'POST',
            url: $("#flow_entry_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="is_flow_active";
            }
        })
    });
    $('#btn_flow_entry_move').click(function() {
        move_flow_id = $('#move_flow_id').val();
        var data = $("#flow_entry_move_form").serialize();

        console.log(data);
        $.ajax({
            type: 'POST',
            url: $(".btn-flow-entry-move").data('url'),
            dataType: 'json',
            data: data ,
            success: function(data) {
                location.href="is_flow_active";
            }
        })
    });
});  

    </script>
@endpush