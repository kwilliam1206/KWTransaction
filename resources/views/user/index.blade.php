@extends('layout.master')
@section('title', trans('nav.users'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ trans('nav.users') }}</h4>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>{{ trans('user.name') }}</th>
                        <th>{{ trans('user.kw_uid') }}</th>
                        <th>{{ trans('user.email') }}</th>
                        <th>{{ trans('user.roles') }}</th>
                        <th>{{ trans('user.created_date') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->kw_uid }}</td>
                            <td>{{ $u->email }}</td>
                            <td>@foreach ($u->roles as $uRole)
                                    {{ $uRole->display_name }}/{{ $uRole->pivot->office->name }}<br>
                                @endforeach
                            </td>
                            <td>{{ $u->created_at->format('m/d/Y h:iA') }}</td>
                            <td>
                                <a href="{{ route('user.edit', ['id' => $u->id]) }}">{{ trans('general.cta_edit') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->
    </div>
@endsection


@section('bottom_scripts')
    <script type="text/javascript">
        window.addEventListener('load', function () {
            var dataTable = $('#datatable').DataTable({
                searching: true,
                lengthChange: false,
                pageLength: 20,
                order: [[4, 'desc']],
                deferRender: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 5}
                ]
            });
        });
    </script>
@endsection