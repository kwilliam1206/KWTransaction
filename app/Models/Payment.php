<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use KW\Transactions\Observers\PaymentObserver;

class Payment extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at','status_change_date','est_paid_date','paid_date'];
    public $fillable = ['created_by','updated_by','transaction_id','currency_id','est_amount','amount','est_paid_date','paid_date','status_id'];

    /**
     * override mass assign update to call mutators
     */

    public function update(array $attributes = [], array $options = [])
    {
        foreach($attributes as $key => $attribute){
            if(in_array($key,$this->fillable))
                $this->{$key} = $attribute;
        }
        return parent::save($options);
    }

    public static function boot() {
        parent::boot();
        Payment::observe(new PaymentObserver());
    }

    public function transaction(){
        return $this->belongsTo('\KW\Transactions\Models\Transaction');
    }

    public function user(){
        return $this->belongsTo('\KW\Transactions\Models\User');
    }

    public function notes(){
        return $this->hasMany('\KW\Transactions\Models\TransactionNote')->orderBy('created_at', 'desc');
    }

    public function logs(){
        return $this->hasMany('\KW\Transactions\Models\TransactionLog')->orderBy('created_at', 'desc');
    }

    public function status(){
        return $this->belongsTo('\KW\Transactions\Models\PaymentStatus');
    }

    public function scopeStatusOf($query,PaymentStatus $status){
        return $query->where('status_id', '=', $status->id);
    }

    public function scopeForOffice($query, $office_id){
        return $query->whereHas('transaction', function ($query) use ($office_id) {
            $query->where('office_id', '=', $office_id);
        });
    }

    public function scopeForOfficeAgent($query, $office_id, $agent_id){
        return $query->whereHas('transaction', function ($query) use ($office_id, $agent_id) {
            $query->where('office_id', '=', $office_id)
                ->where('agent_id', '=', $agent_id);
        });
    }

    public function setEstAmountAttribute($value){
        $this->attributes['est_amount'] = str_replace(",","",$value);
    }

    public function setAmountAttribute($value){
        $this->attributes['amount'] = str_replace(",","",$value);
    }
}
