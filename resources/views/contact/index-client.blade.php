@extends('layout.master')
@section('title', trans('general.agent').' '.trans('general.list'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ trans('general.client')}} {{trans('general.contact')}} {{trans('general.list') }}</h4>
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
                        <th>{{ trans('general.name') }}</th>
                        <th>{{ trans('general.email') }}</th>
                        <th>{{ trans('general.phone') }}</th>
                        <th>{{ trans('general.office') }}</th>
                        <th>{{ trans('property.address') }}</th>
                        <th>{{ trans('property.state') }}</th>
                        <th>{{ trans('property.city') }}</th>
                        <th>{{ trans('property.postal_code') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->first_name.' '.$contact->last_name }}</td>
                            <td><a href="mailto:{{$contact->email}}">{{ $contact->email }}<i class="fa fa-mail"></i></a>
                            </td>
                            <td><a href="phone:{{$contact->primaryPhone->number}}">{{ $contact->primaryPhone->number}}<i
                                            class="fa fa-phone"></i></a></td>
                            <td>{{ $contact->office }}</td>
                            <td>{{ $contact->address }}</td>
                            <td>{{ $contact->state->name }}</td>
                            <td>{{ $contact->city->name }}</td>
                            <td>{{ $contact->postal_code }}</td>
                            <td>
                                {!! Form::model($contact,['method' => 'delete', 'route' => ['contact.destroy',$contact->id],'class' => 'form-horizontal', 'role'=>'form']) !!}
                                <div class="btn-group">
                                    <a class="btn btn-primary"
                                       href="{{ route('contact.edit', ['id' => $contact->id]) }}">{{ trans('general.cta_edit') }}</a>
                                    <button class="btn btn-danger"
                                            href="{{ route('contact.destroy', ['id' => $contact->id]) }}">{{ trans('general.cta_delete') }}</button>
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
                order: [[5, 'desc']],
                paging: false,
                deferRender: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 8}
                ]
            });
        });
    </script>
@endsection