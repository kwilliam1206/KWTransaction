<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;

use KW\Transactions\Http\Requests;
use KW\Transactions\Http\Requests\CreateTransactionRequest;
use KW\Transactions\Http\Requests\UpdateTransactionRequest;
use KW\Transactions\Models\PaymentStatus;
use KW\Transactions\Models\Transaction;
use Illuminate\Support\Facades\Input;
use Auth;
use KW\Transactions\Models\TransactionStatus;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TransactionStatus $status)
    {
        if($status){
            if (Auth::user()->can('approve_transaction')) {
                $transactions = Transaction::with(['status','type','agent','listing','office'])->forOffice($request->cookie('kw_office'))->statusOf($status)->orderBy('updated_at','desc')->get();
            } else {
                $transactions = Transaction::with(['status','type','agent','listing','office'])->forOfficeAgent($request->cookie('kw_office'), Auth::user()->id)->statusOf($status)->orderBy('updated_at','desc')->get();
            }
        }
        else {
            if (Auth::user()->can('approve_transaction')) {
                $transactions = Transaction::with(['status','type','agent','listing','office'])->forOffice($request->cookie('kw_office'))->orderBy('updated_at','desc')->get();
            } else {
                $transactions = Transaction::with(['status','type','agent','listing','office'])->forOfficeAgent($request->cookie('kw_office'), Auth::user()->id)->orderBy('updated_at','desc')->get();
            }
        }
        return view('transaction.index')
            ->with('status',$status)
            ->with('transactions',$transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
        //todo: validation, auth and input sanitize
        $input = array_filter(Input::all(), 'strlen');

        $payments = [];
        if (isset($input['payments'])) {
            foreach(json_decode($input['payments']) as $payment){
                if(!$payment->est_amount && !$payment->est_paid_date)
                    continue;
                $payments[] = (array) $payment;
            }
        }

        if(isset($input['approve']))
            $transaction_status = 'accepted';
        elseif(isset($input['reject']))
            $transaction_status = 'rejected';
        elseif(isset($input['finalized']) && $input['finalized'] == 1)
            $transaction_status = 'submitted';
        else
            $transaction_status = 'draft';

        $transaction_status = TransactionStatus::where('name','=',$transaction_status)->first();
        $input['status_id'] = $transaction_status->id;
        $transaction = Transaction::create($input);
        if(isset($input['note']))
            $transaction->notes()->create($input);
        $transaction->payments()->createMany($payments);
        return redirect()->route('transaction.index.filter',['status'=>$transaction_status->rawname])->with('message',trans('transaction.created_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('modal.transaction-show')
            ->with('transaction',$transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        abort_if($transaction->locked && !Auth::user()->can('approve_transaction'), 403);

        return view('transaction.edit')
            ->with('transaction',$transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //todo: validation, auth and input sanitize
        $input = array_filter(Input::all(), 'strlen');
        $current_payments = $transaction->payments->lists('id');
        $payments_updated = [];
        foreach(json_decode($input['payments']) as $payment){
            if(!$payment->id && !$payment->est_amount && !$payment->est_paid_date)
                continue;
            if($payment->id) {
                $current_payment = $transaction->payments->find($payment->id);
                $current_payment->update((array)$payment);
                array_push($payments_updated,$payment->id);
            }
            else
                $transaction->payments()->create((array) $payment);
        };
        $to_delete = array_diff($current_payments->toArray(), $payments_updated);
        if(count($to_delete))
            $transaction->payments()->whereIn('id',$to_delete)->delete();
        if(isset($input['approve']))
            $transaction_status = 'accepted';
        elseif(isset($input['reject']))
            $transaction_status = 'rejected';
        elseif(isset($input['finalized']))
            $transaction_status = 'submitted';
        else
            $transaction_status = 'draft';
        $transaction_status = TransactionStatus::where('name','=',$transaction_status)->first();
        $input['status_id'] = $transaction_status->id;
        $transaction->update($input);
        if(isset($input['note']))
            $transaction->notes()->create($input);
        return redirect()->route('transaction.index.filter',['status'=>$transaction_status->rawname])->with('message',trans('transaction.updated_msg'));
    }



    /**
     * Withdraw the specified resource
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Transaction $transaction)
    {
        //todo: validation, auth and input sanitize
        $transaction->status()->associate(TransactionStatus::where('name','=','withdrawn')->first());
        $transaction->save();
        return redirect()->route('transaction.index.filter',['status'=>$transaction->status->rawname])->with('message',trans('transaction.withdrawn_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //todo: validation, auth and input sanitize
        $status = $transaction->status->rawname;
        $transaction->delete();
        return redirect()->route('transaction.index.filter',['status'=>$status])->with('message',trans('transaction.deleted_msg'));
    }


    /**
     * Add note to transaction
     *
     * @param \Illuminate\Http\Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function addNote(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'note' => 'required|string',
        ]);

        $transaction->notes()->create($request->all());

        return redirect()->back()->with('addNoteStatus', trans('general.note_added'));
    }

    /**
     * View transaction payments
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function payments(Transaction $transaction)
    {
        if (in_array($transaction->status->rawname, ['accepted', 'pending']) && Auth::user()->can('approve_transaction')) {
            $paymentStatuses = PaymentStatus::whereNotIn('name', ['draft', 'submitted'])->orderBy('id')->pluck('name', 'id');

            return view('transaction.payments')
                ->with('paymentStatuses', $paymentStatuses)
                ->with('transaction',$transaction);
        }

        return view('transaction.payments')
            ->with('transaction',$transaction);
    }
}
