<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    public function states()
    {
        return $this->hasMany('\KW\Transactions\Models\State');
    }

    public function regions()
    {
        return $this->belongsToMany('\KW\Transactions\Models\Region', 'region_countries');
    }
}
