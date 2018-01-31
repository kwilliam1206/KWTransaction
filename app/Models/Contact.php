<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['postal_code','type_id','first_name','last_name','email','address','office_name','state_id','city_id','user_id'];

    public function phones()
    {
        return $this->hasMany('\KW\Transactions\Models\ContactPhone');
    }

    public function primaryPhone(){
        return $this->hasOne('\KW\Transactions\Models\ContactPhone')->primary();
    }

    public function officePhone(){
        return $this->hasOne('\KW\Transactions\Models\ContactPhone')->office();
    }

    public function mobilePhone(){
        return $this->hasOne('\KW\Transactions\Models\ContactPhone')->mobile();
    }

    public function homePhone(){
        return $this->hasOne('\KW\Transactions\Models\ContactPhone')->home();
    }

    public function user()
    {
        return $this->belongsTo('\KW\Transactions\Models\User');
    }

    public function type()
    {
        return $this->belongsTo('\KW\Transactions\Models\ContactType');
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function scopeClients($query)
    {
        return $query->whereHas('type', function($query){
            $query->where('name', '=', 'client');
        });
    }

    public function scopeAgents($query)
    {
        return $query->whereHas('type', function($query){
            $query->where('name', '=', 'agent');
        });
    }

    public function scopeReferrals($query)
    {
        return $query->whereHas('type', function($query){
            $query->where('name', '=', 'referral');
        });
    }

    public function scopeOthers($query)
    {
        return $query->whereHas('type', function($query){
            $query->where('name', '=', 'other');
        });
    }

    public function scopeTypeOf($query,ContactType $type){
        return $query
            ->where('user_id','=',\Auth::user()->id)
            ->where('type_id', $type->id);
    }

    public function state()
    {
        return $this->belongsTo('\KW\Transactions\Models\State');
    }



    public function city()
    {
        return $this->belongsTo('\KW\Transactions\Models\City');
    }
}
