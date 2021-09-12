@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.sites') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/sites/create') }}" class="btn btn-primary">{{ __('backend.create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no')}}</th>
                                <th>{{ __('backend.name')}}</th>
                                <th>{{ __('backend.url')}}</th>
                                <th>{{ __('backend.description')}}</th>
                                <th>{{ __('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($sites)
                                @foreach ($sites as $site)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $site->name }}</td>
                                        <td>{{ $site->url }}</td>
                                        <td>{{ $site->description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/sites/' . $site->id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $site->id }}" class="btn btn-danger btn-site-delete"><i class="fa fa-trash-o"></i></button>
                                              <button type="button" data-id="{{ $site->id }}" data-sites="{{$site}}" class="btn btn-success btn-site-clone"><i class="fa fa-clone"></i></button>
                                              <a href="@php echo("http://front.i4vision.de/?clientname=" .Auth::user()->client->name."&"."site=".$site->name) @endphp"  target="_blank" class="btn btn-primary"><i class="fa fa-desktop"></i></a>
                                            
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

<form id="site_delete_form" data-current_url="{{ url('admin/sites') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="site_clone_form" data-current_url="{{ url('admin/sites/clone') }}" method="POST" action="{{route('admin.sites.clone') }}">
    @csrf
</form>
@endsection

@push('scripts')

    <script>
$(document).ready(function() {
	$('.btn-site-delete').click(function() {
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
                    $("#site_delete_form").attr("action", $("#site_delete_form").data("current_url") + "/" + selectedId);
                    $("#site_delete_form").submit();
                }
            }
        });
    });
    $('.btn-site-clone').click(function() {
        var selectSite = $(this).data("sites");
        console.log(selectSite);
        var data = $("#site_clone_form").serialize();
        data +="&name="+selectSite['name']+"_copy&url="+selectSite['url'].replaceAll('&', '-')+"&description="+selectSite['description'];
    
        
        $.ajax({
            type: 'POST',
            url: $("#site_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="sites";
            }
        })
    });
});    
    
    </script>
    
@endpush
