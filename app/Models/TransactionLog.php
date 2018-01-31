<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $casts = [
        'line' => 'array',
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function transaction()
    {
        return $this->belongsTo('\KW\Transactions\Models\Transaction');
    }

    public function payment()
    {
        return $this->belongsTo('\KW\Transactions\Models\Payment');
    }

    public function type()
    {
        return $this->belongsTo('\KW\Transactions\Models\LogType','log_type_id');
    }

    public function user()
    {
        return $this->belongsTo('\KW\Transactions\Models\User');
    }

    public function getFormattedLineAttribute(){
        if($this->line) {
            return '<strong>'.trans('general.information_updated').'</strong>: '.implode(", ", array_keys($this->line));
        }
        else if ($this->payment) {
            return '<strong>' . $this->type->name . ' ' . trans('general.payment') . '</strong>';
        }
        else {
            return '<strong>' . $this->type->name . ' ' . trans('general.transaction') . '</strong>';
        }
    }
}
