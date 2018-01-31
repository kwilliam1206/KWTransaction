<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    public $fillable = ['transaction_note_id', 'user_id', 'office_id', 'region_id'];

    public function transactionNote()
    {
        return $this->belongsTo('\KW\Transactions\Models\TransactionNote')->with('transaction');
    }

    public function user()
    {
        return $this->belongsTo('\KW\Transactions\Models\User');
    }

    public function office()
    {
        return $this->belongsTo('\KW\Transactions\Models\Office');
    }

    public function region()
    {
        return $this->belongsTo('\KW\Transactions\Models\Region');
    }

}
