<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];

    public function type()
    {
        return $this->belongsTo(TaskType::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class)->with(['agent']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function scopeForOffice($query, $office_id){
        return $query->where('office_id', '=', $office_id);
    }

    public function scopeForOfficeOrUser($query, $office_id, $user_id){
        return $query->where('office_id', '=', $office_id)
            ->orWhere('user_id', '=', $user_id);
    }

    public function scopeStatusOf($query,TransactionStatus $status){
        return $query->where('status_id', '=', $status->id);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', '=', false);
    }

}
