<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use KW\Transactions\Observers\NoteObserver;

class TransactionNote extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    public $fillable = ['created_by', 'transaction_id', 'note'];

    public static function boot()
    {
        parent::boot();
        TransactionNote::observe(new NoteObserver());
    }

    public function transaction()
    {
        return $this->belongsTo('\KW\Transactions\Models\Transaction');
    }

    public function payment()
    {
        return $this->belongsTo('\KW\Transactions\Models\Payment');
    }

    public function user()
    {
        return $this->belongsTo('\KW\Transactions\Models\User','created_by');
    }

    public function mentions()
    {
        return $this->hasMany('\KW\Transactions\Models\Mention');
    }

    public function getNoteText()
    {
        preg_match_all('/(?<!\w)@\w+/', $this->note, $tags);

        return str_replace($tags[0], '', $this->note);
    }
}
