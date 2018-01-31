@extends('layout.modal')
@section('modal.title')
    {{trans('general.transaction')}} #{{$transaction->id}}
@endsection

@section('modal.content')
    <div class="row">
        <label class="col-lg-4">{{trans('general.agent')}}</label>
        <div class="col-lg-8">{{$transaction->agent->name}}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('transaction.transaction_type')}}</label>
        <div class="col-lg-8">{{$transaction->type->name}}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('transaction.submit_date')}}</label>
        <div class="col-lg-8">{{ $transaction->submit_date->format('m/d/Y') }}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('general.status')}}</label>
        <div class="col-lg-8">{{$transaction->status->name}}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('financial.agent_commission')}}</label>
        <div class="col-lg-8">{{$transaction->agent_commission}} ({{$transaction->agentCommissionAttributeType->name}})</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('general.listing')}}</label>
        <div class="col-lg-8">{{$transaction->listing->property->address or '--'}}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('transaction.sale_price')}}</label>
        <div class="col-lg-8">{{ number_format($transaction->price,2) }} {{$locale->currency_code}}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('transaction.sale_date')}}</label>
        <div class="col-lg-8">{{ $transaction->effective_date->format('m/d/Y') }}</div>
    </div>
    <div class="row">
        <label class="col-lg-4">{{trans('general.total')}} {{trans('general.commission')}}</label>
        <div class="col-lg-8">{{$transaction->payment_gross? number_format($transaction->payment_gross,2) : '--'}} {{$locale->currency_code}}</div>
    </div>

    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{trans('general.payments')}}</th>
                <th>{{trans('transaction.expected_date')}}</th>
                <th>{{trans('transaction.paid_date')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->payments as $payment)
            <tr>
                <td>{{number_format($payment->est_amount,2)}} {{$locale->currency_code}}</td>
                <td>{{$payment->est_paid_date->format('Y-m-d')}}</td>
                <td>{{$payment->paid_date? $payment->paid_date->format('Y-m-d') : '--'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection

@section('modal.scripts')
@endsection