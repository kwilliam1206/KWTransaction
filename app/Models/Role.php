<?php

namespace KW\Transactions\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public $timestamps = true;
    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany('KW\Transactions\Models\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('KW\Transactions\Models\Permission');
    }

    public function newPivot(\Illuminate\Database\Eloquent\Model $parent, array $attributes, $table, $exists)
    {
        return new RoleUserPivot($parent, $attributes, $table, $exists);
    }

}
