@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.users') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/users/create') }}" class="btn btn-primary">{{ __('backend.create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __('backend.no')}}</th>
                                <th>{{ __('backend.first_name')}}</th>
                                <th>{{ __('backend.last_name')}}</th>
                                <th>{{ __('backend.username')}}</th>
                                <th>eMail</th>
                                <th>{{ __('backend.phone_number')}}</th>
                                <th>{{ __('backend.gender')}}</th>
                                <th>{{ __('backend.status')}}</th>
                                <th>{{ __('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($users)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>@if ($user->gender == 0) {{ "Male" }} @else {{ "Female" }} @endif</td>
                                        <td>@if ($user->status == 0) {{ "Inactive" }} @else {{ "Active" }} @endif</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/users/' . $user->id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $user->id }}" class="btn btn-danger btn-user-delete"><i class="fa fa-trash-o"></i></button>
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

<form id="user_delete_form" data-current_url="{{ url('admin/users') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')

    <script>
$(document).ready(function () {
	$('.btn-user-delete').click(function() {
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
                    $("#user_delete_form").attr("action", $("#user_delete_form").data('current_url') + "/" + selectedId);
                    $("#user_delete_form").submit();
                }
            }
        });
    });
});    
    </script>
    
@endpush
