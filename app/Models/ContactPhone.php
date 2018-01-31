<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPhone extends Model
{
    public function type()
    {
        return $this->belongsTo('\KW\Transactions\Models\PhoneType');
    }
    public function contact()
    {
        return $this->belongsTo('\KW\Transactions\Models\Contact');
    }
    public function scopePrimary($query)
    {
        return $query->where('primary','=',true)->limit(1);
    }
    public function scopeHome($query)
    {
        return $query->where('type_id','=',PhoneType::where('name',"=",'home')->value('id'))->limit(1);
    }
    public function scopeOffice($query)
    {
        return $query->where('type_id','=',PhoneType::where('name',"=",'office')->value('id'))->limit(1);
    }
    public function scopeMobile($query)
    {
        return $query->where('type_id','=',PhoneType::where('name',"=",'mobile')->value('id'))->limit(1);
    }
}
