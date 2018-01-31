<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use KW\Transactions\Observers\RegionObserver;

class Region extends Model
{
    public static function boot() {
        parent::boot();
        Region::observe(new RegionObserver());
    }

    public function language()
    {
        return $this->belongsTo('\KW\Transactions\Models\Language', 'default_language');
    }

    public function locale()
    {
        return $this->belongsTo('\KW\Transactions\Models\Locale', 'default_locale');
    }

    public function currency()
    {
        return $this->belongsTo('\KW\Transactions\Models\Currency', 'default_currency');
    }

    public function parent()
    {
        return $this->belongsTo('\KW\Transactions\Models\Region', 'parent_id');
    }

    public function countries()
    {
        return $this->belongsToMany('\KW\Transactions\Models\Country', 'region_countries');
    }

    public function offices()
    {
        return $this->hasMany('\KW\Transactions\Models\Office');
    }

    public function customFinancialAttributes()
    {
        return $this->hasMany(CustomFinancialAttribute::class)->with(['financialAttribute'])->whereNull('user_id')->whereNull('office_id');
    }

}
