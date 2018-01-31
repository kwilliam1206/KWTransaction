@extends('layout.master')
@section('title')
    {{$status->name}} {{ trans('payment.list') }}
@endsection
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{$status->name}} {{ trans('payment.list') }}</h4>
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
                        <th>{{ trans('payment.id') }}</th>
                        <th>{{ trans('transaction.id') }}</th>
                        <th>{{ trans('general.agent').' '.trans('general.name')}}</th>
                        <th>{{ trans('transaction.expected_amount') }}</th>
                        <th>{{ trans('transaction.expected_date') }}</th>
                        @if($status->rawname == 'cleared')
                        <th>{{ trans('transaction.paid_amount') }}</th>
                        <th>{{ trans('transaction.paid_date') }}</th>
                        @elseif (in_array($status->rawname, ['approved', 'received']) && Auth::user()->can('approve_transaction'))
                        <th>{{ trans('general.actions') }}</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->transaction->transactionKey }}</td>
                            <td>{{ $payment->transaction->agent->name }}</td>
                            <td>{{ number_format($payment->est_amount,2) }} {{$locale->currency_code}}</td>
                            <td>{{ $payment->est_paid_date->format('Y-m-d') }}</td>
                            @if($status->rawname == 'cleared')
                            <td>{{ number_format($payment->transaction->amount,2) }} {{$locale->currency_code}}</td>
                            <td>{{ $payment->paid_date? $payment->paid_date->format('Y-m-d') : '' }}</td>
                            @elseif (in_array($status->rawname, ['approved', 'received']) && Auth::user()->can('approve_transaction'))
                            <td>
                                {!! Form::model($payment,['method' => 'put', 'route' => ['payment.updateStatus',$payment->id],'class' => 'nowrap', 'role'=>'form']) !!}
                                {!! Form::select('status_id', $paymentStatuses, $payment->status->id, ['class'=>'col-lg-12 select2-no-search', 'onchange'=>'this.form.submit()', 'style' => 'width:100%']) !!}
                                {!! Form::close() !!}
                            </td>
                            @endif
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
                bFilter: false,
                bLengthChange: false,
                iDisplayLength: 10,
                order: [[1, 'desc']]
            });
        });
        $('.select2-no-search').select2({
            minimumResultsForSearch: -1
        });
    </script>
@endsection