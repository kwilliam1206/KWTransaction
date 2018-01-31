<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class State extends Model
{
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo('\KW\Transactions\Models\Country');
    }

    public function counties()
    {
        return $this->hasMany('\KW\Transactions\Models\County');
    }

    public function cities()
    {
        return $this->hasMany('\KW\Transactions\Models\City');
    }

    public function scopeInRegion($query){
        return $query->whereHas('country', function ($query) {
            $query->whereHas('regions', function ($query) {
                $query->whereIn('id', Auth::user()->getRegionsIds());
            });
        });
    }
}
