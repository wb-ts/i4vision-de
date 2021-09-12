@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('backend.clients') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/clients/create') }}" class="btn btn-primary">{{ __ ('backend.create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>{{ __ ('backend.no')}}</th>
                                <th>{{ __ ('backend.name')}}</th>
                                <th>{{ __ ('backend.description')}}</th>
                                <th>#{{ __ ('backend.users')}}</th>
                                <th>#{{ __ ('backend.devices')}}</th>
                                <th>{{ __ ('backend.supervisor_eMail')}}</th>
                                <th>{{ __ ('backend.action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($clients)
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->description }}</td>
                                        <td>{{ $client->users()->count() }}</td>
                                        <td>{{ $client->devices()->count() }}</td>
                                        <td>{{ $client->supervisor_email }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/clients/' . $client->id . '/edit/is_users_of_client_tab_active') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                              <button type="button" data-id="{{ $client->id }}" class="btn btn-danger btn-client-delete"><i class="fa fa-trash-o"></i></button>
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

<form id="client_delete_form" data-current_url="{{ url('admin/clients') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-client-delete').click(function() {
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
                            $("#client_delete_form").attr("action", $("#client_delete_form").data('current_url') + "/" + selectedId);
                            $("#client_delete_form").submit();
                        }
                    }
                });
            });
        });
    </script>
@endpush
