<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = array('postal_code','beds','baths','year_built','habitable_area_sq_m','address','city_id','state_id','subdivision');
    public function listings()
    {
        return $this->hasMany('\KW\Transactions\Models\Listing');
    }

    public function state(){
        return $this->belongsTo('\KW\Transactions\Models\State');
    }

    public function city(){
        return $this->belongsTo('\KW\Transactions\Models\City');
    }

    public function setHabitableAreaSqMAttribute($value){
        $this->attributes['habitable_area_sq_m'] = str_replace(",","",$value);
    }
}
