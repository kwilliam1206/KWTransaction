<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Waavi\Translation\Traits\Translatable;

class PhoneType extends Model
{
    use Translatable;
    protected $translatableAttributes = ['name'];
    public $timestamps=false;
}
