<?php

namespace KW\Transactions\Models;

use Eloquent;

class RoleUserPivot extends \Illuminate\Database\Eloquent\Relations\Pivot
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role_user';

    public function office()
    {
        return $this->hasOne('KW\Transactions\Models\Office','id', 'office_id');
    }

}
