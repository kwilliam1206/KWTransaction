<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use KW\Transactions\Http\Requests;
use KW\Transactions\Models\City;
use KW\Transactions\Models\Contact;
use KW\Transactions\Models\Payment;
use KW\Transactions\Models\PaymentStatus;
use KW\Transactions\Models\Property;
use KW\Transactions\Models\State;
use Auth;
use KW\Transactions\Models\Transaction;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PaymentStatus $status)
    {
        if($status){
            if (Auth::user()->can('approve_transaction')) {
                $payments = Payment::with(['transaction'])->forOffice($request->cookie('kw_office'))->statusOf($status)->get();
            } else {
                $payments = Payment::with(['transaction'])->forOfficeAgent($request->cookie('kw_office'), Auth::user()->id)->statusOf($status)->get();
            }
        }
        else{
            if (Auth::user()->can('approve_transaction')) {
                $payments = Payment::with(['transaction'])->forOffice($request->cookie('kw_office'))->get();
            } else {
                $payments = Payment::with(['transaction'])->forOfficeAgent($request->cookie('kw_office'), Auth::user()->id)->get();
            }
        }

        if (in_array($status->rawname, ['approved', 'received']) && Auth::user()->can('approve_transaction')) {
            $paymentStatuses = PaymentStatus::whereNotIn('name', ['draft', 'submitted'])->orderBy('id')->pluck('name', 'id');

            return view('payment.index')
                ->with('paymentStatuses', $paymentStatuses)
                ->with('status',$status)
                ->with('payments',$payments);
        }

        return view('payment.index')
            ->with('status',$status)
            ->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: validation, auth and input sanitize
        $input = Input::all();
        if(!is_numeric(Input::get('state_id'))) {
            $state = new State();
            $state->name = Input::get('state_id');
            $state->country()->associate(Auth::user()->country);
            $state->save();
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state()->associate($state);
            $city->save();
            $input['state_id'] = $state->id;
            $input['city_id'] = $city->id;
        }
        elseif(!is_numeric(Input::get('city_id'))){
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state_id = Input::get('state_id');
            $city->save();
            $input['city_id'] = $city->id;
        }
        $property = Property::create($input);
        $listing = new Listing();
        $listing->listing_id = Input::get('listing_id');
        $listing->status_id = Input::get('status_id');
        $listing->property()->associate($property);
        $listing->save();
        return redirect()->route('listing.index')->with('message',trans('listing.created_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //todo: validation, auth and input sanitize
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //todo: validation, auth and input sanitize
        $status_id = $payment->status->id;
        $payment->delete();
        return redirect()->route('payment.index.filter',['status'=>$status_id])->with('message',trans('payment.deleted_msg'));
    }

    /**
     * Update payment status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $payment->status_id = $request->get('status_id');
        $payment->save();

        return redirect()->route('transaction.payments',['transaction'=>$payment->transaction->id])->with('message',trans('payment.status_updated_msg'));
    }

}
