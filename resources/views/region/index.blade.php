@extends('layout.master')
@section('title', trans('nav.regions'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ trans('nav.regions') }}</h4>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
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
                        <th>{{ trans('region.name') }}</th>
                        <th>{{ trans('region.kw_id') }}</th>
                        <th>{{ trans('general.default_language') }}</th>
                        <th>{{ trans('general.default_locale') }}</th>
                        <th>{{ trans('general.default_currency') }}</th>
                        <th>{{ trans('general.created_date') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($regions as $reg)
                        <tr>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->kw_id }}</td>
                            <td>{{ $reg->language->name }}</td>
                            <td>{{ $reg->locale->name }}</td>
                            <td>{{ $reg->currency->name }}</td>
                            <td>{{ $reg->created_at->format('m/d/Y h:iA') }}</td>
                            <td>
                                <a href="{{ route('region.edit', ['id' => $reg->id]) }}">{{ trans('general.cta_edit') }}</a>
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
        $(document).ready(function () {
            var dataTable = $('#datatable').DataTable({
                searching: true,
                lengthChange: false,
                pageLength: 20,
                order: [[5, 'desc']],
                deferRender: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 6}
                ]
            });
        });
    </script>
@endsection