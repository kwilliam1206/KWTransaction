@extends('layout.master')
@section('title')
    {{$status->name}} {{ trans('transaction.list') }}
@endsection
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{$status->name}} {{ trans('transaction.list') }}</h4>
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
                        <th>{{ trans('transaction.id') }}</th>
                        <th>{{ trans('transaction.transaction_type') }}</th>
                        <th>{{ trans('general.agent').' '.trans('general.name')}}</th>
                        <th>{{ trans('transaction.price') }}</th>
                        <th>{{ trans('transaction.exp_commission') }}</th>
                        <th>{{ trans('payment.list') }}</th>
                        <th>{{ trans('property.address') }}</th>
                        <th>{{ trans('general.last_modified') }}</th>
                        @can('manage-transaction')
                        <th>{{ trans('general.actions') }}</th>
                        @endcan
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transactionKey }}</td>
                            <td>{{ $transaction->type->name }}</td>
                            <td>{{ $transaction->agent->name }}</td>
                            <td style="white-space: nowrap">{{ number_format($transaction->price,2) }} {{$locale->currency_code}}</td>
                            <td style="white-space: nowrap">{{ number_format($transaction->getEstimatedCommission(),2) }} {{$locale->currency_code}}</td>
                            <td style="white-space: nowrap">{{ count($transaction->payments) }}</td>
                            <td>{{ $transaction->listing->property->address or '--' }}</td>
                            <td style="white-space: nowrap">{{ $transaction->updated_at->format('m/d/Y g:iA') }}</td>
                            @if(in_array($transaction->status->rawname,['draft','rejected']) || Auth::user()->can('manage-transaction'))
                            <td style="width:350px; white-space: nowrap">
                                <div class="btn-group">
                                    @if(in_array($transaction->status->rawname,['draft','rejected','submitted']))
                                    <a class="btn btn-primary"
                                       href="{{ route('transaction.edit', ['id' => $transaction->id]) }}">{{ trans('general.cta_edit') }}</a>
                                    @endif

                                    @if(in_array($transaction->status->rawname,['draft','rejected']))
                                            {!! Form::model($transaction,['method' => 'put', 'route' => ['transaction.withdraw',$transaction->id],'class' => 'nowrap', 'role'=>'form']) !!}
                                            <button class="btn btn-success" href="{{ route('transaction.withdraw', ['id' => $transaction->id]) }}">{{ trans('general.cta_withdraw') }}</button>
                                            {!! Form::close() !!}
                                    @endif
                                    <!--
                                    @if($transaction->status->rawname == 'draft')
                                            {!! Form::model($transaction,['method' => 'delete', 'route' => ['transaction.destroy',$transaction->id],'class' => 'nowrap', 'role'=>'form']) !!}
                                            <button class="btn btn-danger">{{ trans('general.cta_delete') }}</button>
                                            {!! Form::close() !!}
                                    @endif
                                    -->
                                    @if(in_array($transaction->status->rawname, ['accepted', 'pending']))
                                        <a class="btn btn-success"
                                           href="{{ route('transaction.payments', ['transaction' => $transaction]) }}">{{ trans('transaction.apply_payment') }}</a>

                                    @endif
                                </div>
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
                bLengthChange: true,
                iDisplayLength: 10,
                lengthMenu : [[10,20,100], [10,20,100]],
                pageLength : 20,
                order: [[7, 'desc']]
            });
        });
    </script>
@endsection