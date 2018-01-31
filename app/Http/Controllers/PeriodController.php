<?php

namespace KW\Transactions\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use KW\Transactions\Http\Requests;
use KW\Transactions\Models\PaymentStatus;
use KW\Transactions\Models\Transaction;
use Illuminate\Support\Facades\Input;
use Auth;
use KW\Transactions\Models\TransactionStatus;

class PeriodController extends Controller
{
    /**
     * Display completed transactions to freeze.
     *
     * @return \Illuminate\Http\Response
     */
    public function freeze(Request $request)
    {
        abort_if(!Auth::user()->can('freeze_mc'), 403);

        $transactions = Transaction::with(['status','type','agent','listing','office','payments'])
            ->where('closed', '=', false)
            ->forOffice($request->cookie('kw_office'))
            ->statusOf(TransactionStatus::where('name', '=', 'completed')->first())->get();

        return view('period.close')
            ->with('transactions',$transactions);
    }

    /**
     * Close period.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request)
    {
        $ids = $request->get('transactions');

        $count = Transaction::with(['status','type','agent','listing','office','payments'])
            ->where('closed', '=', false)
            ->forOffice($request->cookie('kw_office'))
            ->statusOf(TransactionStatus::where('name', '=', 'completed')->first())
            ->whereIn('id', $ids)
            ->update(['closed' => true, 'closed_date' => Carbon::now()]);

        return redirect()->route('period.freeze')->with('message', $count.' '. trans('transaction.closed_msg'));
    }

}
