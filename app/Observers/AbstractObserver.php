<?php
/**
 * Created by PhpStorm.
 * User: Ogre
 * Date: 6/18/16
 * Time: 1:45 AM
 */

namespace KW\Transactions\Observers;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractObserver {

    abstract public function created(Model $model);

    abstract public function creating(Model $model);

    abstract public function saved(Model $model);

    abstract public function saving(Model $model);

    abstract public function deleted(Model $model);

    abstract public function deleting(Model $model);

    abstract public function restoring(Model $model);

    abstract public function restored(Model $model);

    abstract public function updated(Model $model);

    abstract public function updating(Model $model);
}