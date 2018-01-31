<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Waavi\Translation\Traits\Translatable;

class UserStatus extends Model
{
    use Translatable;
    protected $translatableAttributes = ['name'];
    public $timestamps = false;

    public function status()
    {
        return $this->belongsTo('\KW\Transactions\Models\UserStatus');
    }
}
