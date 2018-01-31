<?php
/**
 * Created by PhpStorm.
 * User: Ogre
 * Date: 6/18/16
 * Time: 1:45 AM
 */

namespace KW\Transactions\Observers;

use Illuminate\Database\Eloquent\Model;

class OfficeObserver extends AbstractObserver
{
    public function created(Model $model)
    {
    }

    public function creating(Model $model)
    {
        if (is_null($model->kw_id)) {
            $model->kw_id = md5(microtime());
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
    }

    public function deleting(Model $model)
    {
    }

    public function restoring(Model $model)
    {
    }

    public function restored(Model $model)
    {
    }

    public function updated(Model $model)
    {
    }

    public function updating(Model $model)
    {
    }
}