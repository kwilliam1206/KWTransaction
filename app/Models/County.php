<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo('\KW\Transactions\Models\Country');
    }

    public function state()
    {
        return $this->belongsTo('\KW\Transactions\Models\State');
    }

    public function cities()
    {
        return $this->belongsToMany('\KW\Transactions\Models\City', 'city_counties');
    }
}
