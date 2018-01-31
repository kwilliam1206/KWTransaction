<?php

namespace KW\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = ['listing_id','status_id'];
    public function property()
    {
        return $this->belongsTo('\KW\Transactions\Models\Property')->with(['city','state']);
    }
    public function status()
    {
        return $this->belongsTo('\KW\Transactions\Models\ListingStatus');
    }

    public function getNameAttribute(){
        return $this->listing_id.' - '.$this->property->address;
    }

    public function scopeActiveOrPendingOrSold($query)
    {
        return $query->whereIn('status_id', ListingStatus::whereIn("name",["active","pending","sold"])->lists('id'));
    }

    public function scopeStatusOf($query, ListingStatus $status){
        return $query->where('status_id', '=', $status->id);
    }
}
