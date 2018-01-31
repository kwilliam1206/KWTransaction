@extends('layout.master')
@section('title', trans('nav.offices'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ trans('nav.offices') }}</h4>
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
                        <th>{{ trans('office.name') }}</th>
                        <th>{{ trans('office.kw_id') }}</th>
                        <th>{{ trans('general.region') }}</th>
                        <th>{{ trans('general.default_language') }}</th>
                        <th>{{ trans('general.default_locale') }}</th>
                        <th>{{ trans('general.default_currency') }}</th>
                        <th>{{ trans('general.created_date') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($offices as $off)
                        <tr>
                            <td>{{ $off->name }}</td>
                            <td>{{ $off->kw_id }}</td>
                            <td>{{ $off->region->name }}</td>
                            <td>{{ $off->language->name }}</td>
                            <td>{{ $off->locale->name }}</td>
                            <td>{{ $off->currency->name }}</td>
                            <td>{{ $off->created_at->format('m/d/Y h:iA') }}</td>
                            <td>
                                <a href="{{ route('office.edit', ['id' => $off->id]) }}">{{ trans('general.cta_edit') }}</a>
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
                order: [[6, 'desc']],
                deferRender: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 7}
                ]
            });
        });
    </script>
@endsection