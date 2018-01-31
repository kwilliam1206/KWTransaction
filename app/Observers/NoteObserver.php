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
use KW\Transactions\Models\Office;
use KW\Transactions\Models\User;

class NoteObserver extends AbstractObserver
{
    public function created(Model $model)
    {
        if ($model instanceof \KW\Transactions\Models\TransactionNote) {
            preg_match_all('/(?<!\w)@\w+/', $model->note, $tags);

            foreach ($tags[0] as $tag) {
                switch ($tag) {
                    case '@agent':
                        $model->mentions()->create([
                            'transaction_note_id' => $model->id,
                            'user_id' => $model->transaction->agent->id,
                        ]);
                        break;
                    case '@office':
                        $model->mentions()->create([
                            'transaction_note_id' => $model->id,
                            'office_id' => $model->transaction->office->id,
                        ]);
                        break;
                    case '@region':
                        $model->mentions()->create([
                            'transaction_note_id' => $model->id,
                            'region_id' => $model->transaction->office->region->id,
                        ]);
                        break;
                    default:
                        $user = User::where('username', '=', ltrim($tag, '@'))->first();
                        if ($user) {
                            $model->mentions()->create([
                                'transaction_note_id' => $model->id,
                                'user_id' => $user->id,
                            ]);
                        }
                        break;
                }
            }
        }
    }

    public function creating(Model $model)
    {
        $model->created_by = Auth::user()->id;
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