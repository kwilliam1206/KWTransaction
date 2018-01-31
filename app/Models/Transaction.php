<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use KW\Transactions\Observers\TransactionObserver;

class Transaction extends Model
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at','status_change_date','effective_date', 'submit_date'];
    use SoftDeletes;
    protected $fillable = ['est_commission', 'commission', 'type_id','status_id','agent_id','office_id','created_by','buyer_contact_id','seller_contact_id','buyer_agent_contact_id','seller_agent_contact_id','listing_id','price','effective_date','currency_id',
            'agent_commission', 'agent_commission_type'];

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
        Transaction::observe(new TransactionObserver());
    }

    public function notes()
    {
        return $this->hasMany('\KW\Transactions\Models\TransactionNote')->orderBy('created_at', 'desc');
    }

    public function payments()
    {
        return $this->hasMany('\KW\Transactions\Models\Payment');
    }

    public function logs()
    {
        return $this->hasMany('\KW\Transactions\Models\TransactionLog')->orderBy('created_at', 'desc');
    }

    public function status()
    {
        return $this->belongsTo('\KW\Transactions\Models\TransactionStatus');
    }

    public function listing()
    {
        return $this->belongsTo('\KW\Transactions\Models\Listing')->with(['property']);
    }

    public function getEstimatedCommission()
    {
        $c = $this->agent_commission;
        if ($this->agentCommissionAttributeType->rawname == 'percent') {
            $c = $this->price * $this->agent_commission / 100;
        }
        return $c;
    }

    public function getCommission()
    {
        return  $this->payments->sum(function ($payment) {
            return $payment->amount;
        });
    }

    public function agent()
    {
        return $this->belongsTo('\KW\Transactions\Models\User');
    }

    public function office()
    {
        return $this->belongsTo('\KW\Transactions\Models\Office');
    }

    public function type()
    {
        return $this->belongsTo('\KW\Transactions\Models\TransactionType');
    }

    public function agentCommissionAttributeType()
    {
        return $this->belongsTo(FinancialAttributeType::class, 'agent_commission_type');
    }

    public function scopeStatusOf($query,TransactionStatus $status){
        return $query->where('status_id', '=', $status->id);
    }

    public function scopeForOffice($query, $office_id){
        return $query->where('office_id', '=', $office_id);
    }

    public function scopeForOfficeAgent($query, $office_id, $agent_id){
        return $query->where('office_id', '=', $office_id)
            ->where('agent_id', '=', $agent_id);
    }

    public function setPriceAttribute($value){
        //todo handle variable money format
        $this->attributes['price'] = str_replace(",","",$value);
    }

    public function setEstCommisionAttribute($value){
        $this->attributes['est_commission'] = str_replace(",","",$value);
    }

    public function setCommisionAttribute($value){
        $this->attributes['commission'] = str_replace(",","",$value);
    }

    public function getAttribute($attribute)
    {
        if ($attribute == 'transactionKey') {
            return 'TR-'.parent::getAttribute('id');
        }

        // Return parent
        return parent::getAttribute($attribute);
    }
}
