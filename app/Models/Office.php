<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use KW\Transactions\Observers\OfficeObserver;

class Office extends Model
{
    public static function boot() {
        parent::boot();
        Office::observe(new OfficeObserver());
    }

    public function region()
    {
        return $this->belongsTo('\KW\Transactions\Models\Region');
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

    public function customFinancialAttributes()
    {
        return $this->hasMany(CustomFinancialAttribute::class)->with(['financialAttribute'])->whereNull('user_id');
    }

}
