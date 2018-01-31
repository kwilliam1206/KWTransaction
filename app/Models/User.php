<?php

namespace KW\Transactions\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('\KW\Transactions\Models\Role')->withPivot('office_id');
    }

    public function offices(){
        return $this->belongsToMany('\KW\Transactions\Models\Office','role_user');
    }

    public function newPivot(\Illuminate\Database\Eloquent\Model $parent, array $attributes, $table, $exists)
    {
        return new RoleUserPivot($parent, $attributes, $table, $exists);
    }

    public function contacts()
    {
        return $this->hasMany('\KW\Transactions\Models\Contact');
    }

    public function language()
    {
        return $this->belongsTo('\KW\Transactions\Models\Language');
    }

    public function locale()
    {
        return $this->belongsTo('\KW\Transactions\Models\Locale');
    }

    public function currency()
    {
        return $this->belongsTo('\KW\Transactions\Models\Currency');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function completedTasks()
    {
        return $this->hasMany(Task::class, 'completed_by');
    }

    public function customFinancialAttributes()
    {
        return $this->hasMany(CustomFinancialAttribute::class);
    }

    public function officeAttributes()
    {
        return $this->hasMany(UserOfficeAttribute::class);
    }

    public function getRegionsIds()
    {
        return $this->offices()->lists('region_id');
    }

    public function getCountryAttribute(){
        return $this->offices()->first()->region->countries->first();
    }

    public function getUserManagingRegionIds()
    {
        return Region::whereHas('offices',function($query){
            $query->whereIn('id', $this->getUserManagingOfficeIds());
        })->lists('id');
    }

    public function getUserManagingOfficeIds()
    {
        $officeIds = [];
        foreach ($this->roles as $role) {
            if ($role->name == 'super_admin' || stripos($role->name, 'kwri_') === 0 ||
                stripos($role->name, 'region_') === 0 || stripos($role->name, 'mc_') === 0) {
                $officeIds[] = $role->pivot->office_id;
            }
        }

        return $officeIds;
    }

    public function isManagingOffice($officeId)
    {
        return in_array($officeId, $this->getUserManagingOfficeIds());
    }

    public function isManagingRegion($regionId)
    {
        return in_array($regionId, $this->getUserManagingRegionIds());
    }

    public function scopeAgents($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->whereIn('role_id', Role::whereIn("name",["agent","lead_agent"])->lists('id'));
        });
    }

    public function scopeInOffice($query, $office_id)
    {
        return $query->whereHas('offices', function ($query) use ($office_id) {
            $query->where('id', '=', $office_id);
        });
    }

    public function getMentions($limit=null)
    {
        $query = Mention::with('transactionNote')
            ->where('hide', '=', false)
            ->where(function ($query) {
                $query->where('user_id', '=', $this->id)
                    ->orWhereIn('office_id', $this->getUserManagingOfficeIds())
                    ->orWhereIn('region_id', $this->getUserManagingRegionIds());
            })
            ->orderBy('created_at', 'desc');

        if (!is_null($limit)) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function isAgent()
    {
        return $this->hasRole("agent") || $this->hasRole("lead_agent");
    }

    public function getAttribute($attribute)
    {
        if ($attribute == 'name') {
            return parent::getAttribute('first_name').' '.parent::getAttribute('last_name');
        }

        // Return parent
        return parent::getAttribute($attribute);
    }
}
