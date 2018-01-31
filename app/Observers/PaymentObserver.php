<?php
/**
 * Created by PhpStorm.
 * User: Ogre
 * Date: 6/18/16
 * Time: 1:45 AM
 */

namespace KW\Transactions\Observers;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use KW\Transactions\Models\LogType;
use KW\Transactions\Models\TransactionLog;
use KW\Transactions\Models\PaymentStatus;
use KW\Transactions\Models\TransactionStatus;

class PaymentObserver extends AbstractObserver
{
    public function created(Model $model)
    {
        $log = new TransactionLog();
        $log->type()->associate(LogType::where('name', '=', 'create')->first());
        $log->transaction()->associate($model->transaction);
        $log->payment()->associate($model);
        $log->line = null;
        $log->user()->associate(Auth::user());
        $log->save();
    }

    public function creating(Model $model)
    {
        $model->created_by = Auth::user()->id;
        $model->currency_id = Auth::user()->currency_id;
        $model->status_change_date = Carbon::now();
        $model->status_id = PaymentStatus::where('name','=','draft')->value('id');
    }

    public function saved(Model $model)
    {
    }

    public function saving(Model $model)
    {
    }

    public function deleted(Model $model)
    {
        $log = new TransactionLog();
        $log->type()->associate(LogType::where('name', '=', 'delete')->first());
        $log->transaction()->associate($model->transaction);
        $log->payment()->associate($model);
        $log->line = null;
        $log->user()->associate(Auth::user());
        $log->save();
    }

    public function deleting(Model $model)
    {
        //$model->status_change_date = Carbon::now();
    }

    public function restoring(Model $model)
    {
        //$model->status_change_date = Carbon::now();
    }

    public function restored(Model $model)
    {
    }

    public function updated(Model $model)
    {
        $log = new TransactionLog();
        $log->type()->associate(LogType::where('name', '=', 'update')->first());
        $log->transaction()->associate($model->transaction);
        $log->payment()->associate($model);
        $log->line = $model->getDirty();
        $log->user()->associate(Auth::user());
        $log->save();

        if ($model->isDirty('status_id')){
            if (in_array($model->status->rawname, ['received', 'cleared'])) {
                $transaction = $model->transaction;
                $allCleared = true;
                foreach ($transaction->payments as $payment) {
                    if ($payment->status->rawname != 'cleared') {
                        $allCleared = false;
                        break;
                    }
                }

                $transaction->status_id = $allCleared? TransactionStatus::where('name','=','completed')->value('id') : TransactionStatus::where('name','=','pending')->value('id');
                $transaction->payment_gross = $transaction->getCommission();
                $transaction->save();
            }
        }
    }

    public function updating(Model $model)
    {
        $model->updated_by = Auth::user()->id;
        if ($model->isDirty('status_id')){
            $model->status_change_date = Carbon::now();
        }
    }
}