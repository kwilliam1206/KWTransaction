<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Waavi\Translation\Traits\Translatable;

class FinancialAttribute extends Model
{
    use Translatable;
    protected $translatableAttributes = ['name'];
    protected $dates = ['created_at', 'updated_at'];
    public $fillable = ['name', 'type_id', 'value', 'lock_type', 'created_by'];

    public function type()
    {
        return $this->belongsTo(FinancialAttributeType::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
