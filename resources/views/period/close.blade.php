@extends('layout.master')
@section('title')
    {{ trans('nav.close') }}
@endsection
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{ trans('nav.close') }}</h4>
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

                {!! Form::open(['id'=>'monthly_close_form','method' => 'put', 'route' => ['period.close'],'class' => 'form-horizontal', 'role'=>'form']) !!}

                @if (count($transactions))
                <div class="col-sm-12">
                    <div class="row">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ trans('transaction.freeze') }}</button>
                    </div>
                </div>
                @endif

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{ trans('general.id') }}</th>
                        <th>{{ trans('transaction.transaction_type') }}</th>
                        <th>{{ trans('general.agent').' '.trans('general.name')}}</th>
                        <th>{{ trans('transaction.price') }}</th>
                        <th>{{ trans('payment.list') }}</th>
                        <th>{{ trans('transaction.est_commission') }}</th>
                        <th>{{ trans('transaction.commission') }}</th>
                        <th>{{ trans('property.address') }}</th>
                        <th>{{ trans('general.last_modified') }}</th>
                        <th>{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="checkbox checkbox-success" style="margin-top:4px;">
                                    <input id="trans_{{ $transaction->id }}" name="transactions[]" value="{{ $transaction->id }}" type="checkbox" checked>
                                    <label for="trans_{{ $transaction->id }}"></label>
                                </div>
                            </td>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->type->name }}</td>
                            <td>{{ $transaction->agent->name }}</td>
                            <td style="white-space: nowrap">{{ number_format($transaction->price,2) }} {{$locale->currency_code}}</td>
                            <td style="white-space: nowrap">{{ count($transaction->payments()) }}</td>
                            <td style="white-space: nowrap">{{ number_format($transaction->getEstimatedCommission(),2) }} {{$locale->currency_code}}</td>
                            <td style="white-space: nowrap">{{ number_format($transaction->getCommission(),2) }} {{$locale->currency_code}}</td>
                            <td>{{ $transaction->listing->property->address or '--' }}</td>
                            <td style="white-space: nowrap">{{ $transaction->updated_at->format('m/d/Y g:iA') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" data-plugin="modalTrigger"
                                       href="{{ route('transaction.show', ['transaction' => $transaction]) }}">{{ trans('general.cta_view') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}

            </div>
        </div><!-- end col -->
    </div>
@endsection


@section('bottom_scripts')
    <script type="text/javascript">
        window.addEventListener('load', function () {
            var dataTable = $('#datatable').DataTable({
                bFilter: false,
                bLengthChange: false,
                iDisplayLength: 10,
                order: [[1, 'desc']],
                "columnDefs": [ {
                    "targets": 0,
                    "orderable": false
                } ]
            });

            $('[data-plugin="modalTrigger"]').on('click', function(e) {
                Custombox.open({
                    target: $(this).attr("href")
                });
                e.preventDefault();
            });
        });
    </script>
@endsection