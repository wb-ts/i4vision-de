@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('backend.devices') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
								@if(Auth()->user()->type == "super_admin")
									<th>{{ __('backend.clients')}}</th>
								  	<th>{{ __('backend.code')}}</th>
								  	<th>{{ __('backend.description')}}</th>
								@else
								  <th>{{ __('backend.description')}}</th>
								  <th>{{ __('backend.code')}}</th>
								@endif
                                <th>{{ __('backend.active')}}</th>
                                <th>{{ __('backend.last_access')}}</th>
                                <th>{{ __('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($devices)
                                @foreach ($devices as $device)
                                    <tr>
										@if(Auth()->user()->type == "super_admin")
											<td>@if ($device->client) {{ $device->client->name }} @endif</td>
											<td>{{ $device->device_code }}</td>
											<td>{{ \Illuminate\Support\Str::limit($device->description, 20, $end='...') }}</td>
										@else
											<td>{{ \Illuminate\Support\Str::limit($device->description, 20, $end='...') }}</td>
											<td>{{ $device->device_code }}</td>
										@endif
                                        
                                        <td>@if ($device->enabled) Enabled @else Disabled @endif</td>
                                        <td>{{ $device->timestamp_last_accessed }}</td>                                        
                                        <td>
											<div class="btn-group btn-group-sm">
												<a data-url="{{url('admin/devices/' . $device->id)}}" href="{{ url('admin/devices/' . $device->id . '/edit') }}" class="btn btn-primary btn-edit-device"><i class="fa fa-edit"></i></a>
												<button type="button" data-id="{{ $device->id }}" class="btn btn-danger btn-device-delete"><i class="fa fa-trash-o"></i></button>
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

<form id="device_delete_form" data-current_url="{{ url('admin/devices') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>

@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
    
    device_edit_url = $("#device_edit").attr("action");
    //alert(device_edit_url);
	$('.btn-device-delete').click(function() {
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
                    $("#device_delete_form").attr("action", $("#device_delete_form").data('current_url') + "/" + selectedId);
                    $("#device_delete_form").submit();
                }
            }
        });
    });
    $("#show_at_frontend").change(function () {
        var show_at_frontend = $(this).val();
        // alert(device_edit_url);

        $.ajax({
            
            url: device_edit_url + '/get_frontend_refers',
            method: 'GET',
            dataType: 'json',
            data: {'show_at_frontend': show_at_frontend},
            success: function(data, textStatus, jqXHR) {
                if(show_at_frontend == "Free"){
                    optionHtml = '<input name="frontend_refer" class="form-control" placeholder="Input URL..."></input>';
                }
                else {
                    var optionHtml = '<select name="frontend_refer" class="form-control" ><option value="">Select Name</option>';

                    if (show_at_frontend == 'App\\Schedule' || show_at_frontend == 'App\\Flow') {
                        for (var i = 0; i < data.frontend_refers.length; i++) {
                            optionHtml += '<option value="' + data.frontend_refers[i].name + '">' + data.frontend_refers[i].name + '</option>';
                        }
                    } else {

                        for (var i = 0; i < data.frontend_refers.length; i++) {
                            optionHtml += '<option value="' + data.frontend_refers[i].name + '">' + data.frontend_refers[i].name + '</option>';
                        }
                    }
                    optionHtml+="</select>";
                }
                
                
                $("#frontend_refer").html(optionHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $("#enabled").change(function(){
        if ($(this).is(":checked")){
            $(this).attr("value",1);
        }
        else {
            $(this).attr("value",0);
        }
    });
    $("#force_restart_enabled").change(function(){
        if ($(this).is(":checked")){
            $(this).attr("value",1);
        }
        else {
            $(this).attr("value",0);
        }
    });
});
    </script>
@endpush
