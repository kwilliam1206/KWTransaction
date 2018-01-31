<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    public function counties()
    {
        return $this->belongsToMany('\KW\Transactions\Models\County', 'city_counties');
    }

    public function state()
    {
        return $this->belongsTo('\KW\Transactions\Models\State');
    }
}
