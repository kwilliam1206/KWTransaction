<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomFinancialAttribute extends Model
{
    protected $dates = ['waiver_date', 'created_at', 'updated_at'];
    public $fillable = ['financial_attribute_id', 'region_id', 'office_id', 'user_id', 'value', 'waiver', 'waiver_date', 'created_by'];

    public function financialAttribute()
    {
        return $this->belongsTo(FinancialAttribute::class)->with(['type']);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(FinancialAttributeType::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeForOffice($query, $office){
        return $query->with(['financialAttribute'])
            ->join(DB::raw('
                (SELECT financial_attribute_id, max(office_id) as office_id, max(region_id) as region_id
                FROM custom_financial_attributes
                WHERE user_id is null AND (office_id = '. $office->id .' OR region_id = '. $office->region->id .')
                GROUP BY financial_attribute_id) AS d
                '), function ($join) {
                $join->on('custom_financial_attributes.financial_attribute_id', '=', 'd.financial_attribute_id')
                    ->on(DB::raw('user_id is null AND (d.office_id = custom_financial_attributes.office_id
                    OR (d.office_id is null AND d.region_id = custom_financial_attributes.region_id))'), DB::raw(''), DB::raw(''));
            })
            ->orderBy('custom_financial_attributes.financial_attribute_id', 'asc');
    }

    public function scopeForOfficeUser($query, $office, $user, $name=null){
        $query->with(['financialAttribute'])
            ->join(DB::raw('
                (SELECT financial_attribute_id, max(user_id) as user_id, max(office_id) as office_id, max(region_id) as region_id
                FROM custom_financial_attributes
                WHERE (user_id is null OR user_id = '. $user->id .') AND ((user_id is null AND office_id is null) OR office_id = '. $office->id .') AND region_id = '. $office->region->id .'
                GROUP BY financial_attribute_id) AS d
                '), function ($join) {
                $join->on('custom_financial_attributes.financial_attribute_id', '=', 'd.financial_attribute_id')
                    ->on(DB::raw('((d.user_id = custom_financial_attributes.user_id AND d.office_id = custom_financial_attributes.office_id)
                    OR (d.user_id is null AND d.office_id = custom_financial_attributes.office_id)
                    OR (d.user_id is null AND d.office_id is null AND d.region_id = custom_financial_attributes.region_id))'), DB::raw(''), DB::raw(''));
            })
            ->whereRaw('(custom_financial_attributes.user_id is null OR custom_financial_attributes.user_id = '. $user->id .') AND ((custom_financial_attributes.user_id is null AND custom_financial_attributes.office_id is null) OR custom_financial_attributes.office_id = '. $office->id .') AND custom_financial_attributes.region_id = '. $office->region->id)
            ->orderBy('custom_financial_attributes.financial_attribute_id', 'asc');

        if ($name) {
            $query->whereHas('financialAttribute', function($query) use ($name) {
                $query->where('name', '=', $name);
            });
        }

        return $query;
    }

}
