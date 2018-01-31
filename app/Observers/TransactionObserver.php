<?php
/**
 * Created by PhpStorm.
 * User: Ogre
 * Date: 6/18/16
 * Time: 1:45 AM
 */

namespace KW\Transactions\Observers;

use Auth;
use Illuminate\Database\Eloquent\Model;
use KW\Transactions\Models\LogType;
use KW\Transactions\Models\PaymentStatus;
use KW\Transactions\Models\Task;
use KW\Transactions\Models\TaskType;
use KW\Transactions\Models\TransactionLog;
use Carbon\Carbon;
use KW\Transactions\Models\TransactionStatus;

class TransactionObserver extends AbstractObserver
{
    public function created(Model $model)
    {
        $log = new TransactionLog();
        $log->type()->associate(LogType::where('name', '=', 'create')->first());
        $log->transaction()->associate($model);
        $log->line = null;
        $log->user()->associate(Auth::user());
        $log->save();

        if ($model->status->rawname == 'submitted') {
            $task = new Task();
            $task->type()->associate(TaskType::where('name', '=', 'transaction_submitted')->first());
            $task->transaction()->associate($model);
            $task->office()->associate($model->office);
            $task->save();
        } elseif (in_array($model->status->rawname, ['accepted', 'rejected'])) {
            $task = Task::where('type_id', '=', TaskType::where('name', '=', 'transaction_submitted')->value('id'))
                ->where('transaction_id', '=', $model->id)
                ->first();
            if ($task) {
                $task->completed = true;
                $task->completedBy()->associate(Auth::user());
                $task->save();
            }
        }
    }

    public function creating(Model $model)
    {
        $model->currency_id = Auth::user()->currency_id;
        //todo: multi office
        $model->office_id = Auth::user()->offices()->first()->id;
        $model->status_change_date = Carbon::now();
        $model->created_by = Auth::user()->id;
        if ($model->status->rawname == 'submitted') {
            $model->submit_date = $model->status_change_date;
            $model->locked = true;

            $paymentStatusId = PaymentStatus::where('name','=','submitted')->value('id');
            foreach ($model->payments as $payment) {
                $payment->status_id = $paymentStatusId;
                $payment->save();
            }

        } elseif ($model->status->rawname == 'accepted') {
            $model->office_approved = true;

            $paymentStatusId = PaymentStatus::where('name','=','approved')->value('id');
            foreach ($model->payments as $payment) {
                $payment->status_id = $paymentStatusId;
                $payment->save();
            }

        } elseif ($model->status->rawname == 'rejected') {
            $model->office_approved = false;
            $model->locked = false;
        }
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
        $log->transaction()->associate($model);
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
        $log->transaction()->associate($model);
        $log->line = $model->getDirty();
        $log->user()->associate(Auth::user());
        $log->save();

        if ($model->isDirty('status_id')){
            if ($model->status->rawname == 'submitted') {
                $task = new Task();
                $task->type()->associate(TaskType::where('name', '=', 'transaction_submitted')->first());
                $task->transaction()->associate($model);
                $task->office()->associate($model->office);
                $task->save();
            } elseif (in_array($model->status->rawname, ['accepted', 'rejected'])) {
                $task = Task::where('transaction_id', '=', $model->id)
                    ->where('type_id', '=', TaskType::where('name', '=', 'transaction_submitted')->value('id'))
                    ->first();
                if ($task) {
                    $task->completed = true;
                    $task->completedBy()->associate(Auth::user());
                    $task->save();
                }
            }
        }
    }

    public function updating(Model $model)
    {
        $model->updated_by = Auth::user()->id;
        if ($model->isDirty('status_id')){
            $model->status_change_date = Carbon::now();
            if ($model->status->rawname == 'submitted') {
                $model->submit_date = $model->status_change_date;
                $model->locked = true;

                $paymentStatusId = PaymentStatus::where('name','=','submitted')->value('id');
                foreach ($model->payments as $payment) {
                    $payment->status_id = $paymentStatusId;
                    $payment->save();
                }

            } elseif ($model->status->rawname == 'accepted') {
                $model->office_approved = true;

                $paymentStatusId = PaymentStatus::where('name','=','approved')->value('id');
                foreach ($model->payments as $payment) {
                    $payment->status_id = $paymentStatusId;
                    $payment->save();
                }

            } elseif ($model->status->rawname == 'rejected') {
                $model->office_approved = false;
                $model->locked = false;
            }
        }
    }
}