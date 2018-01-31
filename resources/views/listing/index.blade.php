@extends('layout.master')
@section('title')
    {{ $status->name }} {{ trans('general.listings') }}
@endsection
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ $status->name }} {{ trans('general.listings') }}</h4>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @endif

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>{{ trans('listing.id') }}</th>
                        <th>{{ trans('property.address') }}</th>
                        <th>{{ trans('property.state') }}</th>
                        <th>{{ trans('property.city') }}</th>
                        <th>{{ trans('property.postal_code') }}</th>
                        <th>{{ trans('general.status') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($listings as $listing)
                        <tr>
                            <td>{{ $listing->listing_id }}</td>
                            <td>{{ $listing->property->address }}</td>
                            <td>{{ $listing->property->state->name   }}</td>
                            <td>{{ $listing->property->city->name }}</td>
                            <td>{{ $listing->property->postal_code }}</td>
                            <td>{{ $listing->status->name }}</td>
                            <td>
                                {!! Form::model($listing,['method' => 'delete', 'route' => ['listing.destroy',$listing->id],'class' => 'form-horizontal', 'role'=>'form']) !!}
                                <div class="btn-group">
                                    <a class="btn btn-primary"
                                       href="{{ route('listing.edit', ['id' => $listing->id]) }}">{{ trans('general.cta_edit') }}</a>
                                    <a class="btn btn-success"
                                       href="#">{{ trans('general.new') }} {{ trans('general.transaction') }}</a>
                                    <button class="btn btn-danger"
                                            href="{{ route('listing.destroy', ['id' => $listing->id]) }}">{{ trans('general.cta_delete') }}</button>
                                </div>
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
                bFilter: true,
                bLengthChange: true,
                iDisplayLength: 10,
                order: [[4, 'desc']],
                paging: false,
                deferRender: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 6}
                ]
            });
        });
    </script>
@endsection