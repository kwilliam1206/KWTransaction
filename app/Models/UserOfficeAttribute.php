<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class UserOfficeAttribute extends Model
{
    protected $dates = ['anniversary_date', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function scopeForOfficeUser($query, $office_id, $user_id){
        return $query->where('office_id', '=', $office_id)
            ->orWhere('user_id', '=', $user_id);
    }

}
