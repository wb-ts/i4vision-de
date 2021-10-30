@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.galleries') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/galleries/create') }}" class="btn btn-primary">{{ __('backend.create') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no') }}</th>
                                <th>{{ __('backend.name') }}</th>
                                <th>{{ __('backend.google_link') }}</th>
                                <th>{{ __('backend.description') }}</th>
                                <th>{{ __('backend.action') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($galleries)
                                @foreach ($galleries as $gallery)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $gallery->name }}</td>
                                        <td>{{ $gallery->google_link }}</td>
                                        <td>{{ $gallery->description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/galleries/' . $gallery->id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $gallery->id }}" class="btn btn-danger btn-gallery-delete"><i class="fa fa-trash-o"></i></button>
											  <button type="button" data-id="{{ $gallery->id }}" class="btn btn-success btn-gallery-clone"><i class="fa fa-clone"></i></button>
                                              <a href="@php echo("http://front.i4vision.de/?clientname=" .Auth::user()->client->name."&"."google=".$gallery->name) @endphp"  target="_blank"  class="btn btn-primary"><i class="fa fa-desktop"></i></a>
                                            
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

<form id="gallery_delete_form" data-current_url="{{ url('admin/galleries') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
<form id="gallery_clone_form" data-current_url="{{ url('admin/galleries/clone') }}" method="POST" action="{{route('admin.galleries.clone') }}">
    @csrf
</form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.googleslides.js') }}"></script>

    <script type="text/javascript">
    
$(document).ready(function() {
	$('.btn-gallery-delete').click(function() {
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
                    $("#gallery_delete_form").attr("action", $("#gallery_delete_form").data('current_url') + "/" + selectedId);
                    $("#gallery_delete_form").submit();
                }
            }
        });
    });
    $('.btn-gallery-clone').click(function() {

        var data = $("#gallery_clone_form").serialize();
        var temp = $(this).parent().parent().siblings(),temp_datas  = {"name":"","google_link":"","description":""};
        for(var i =1 ;i<temp.length;i++){
            temp_datas['name'] = temp[1].innerText;
            temp_datas['google_link'] = temp[2].innerText;
            temp_datas['description'] = temp[3].innerText;
            // temp_datas.push(temp_keys[i] : temp[i].innerText);
        }
        data +="&name="+temp_datas['name']+"_copy&google_link="+temp_datas['google_link']+"&description="+temp_datas['description'];
       
        
        //console.log(temp_datas);
        $.ajax({
            type: 'POST',
            url: $("#gallery_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="galleries";
            }
        })
    });
    
})
    
    </script>
@endpush
