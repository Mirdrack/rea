<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class StationEvent extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'station_events';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['user_id', 'station_id', 'event_type_id', 'ip_address']; 

    public function setUpdatedAtAttribute($value)
    {
        // Do nothing because we don't need the updated_at attribute.
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function event_type()
    {
        return $this->belongsTo(EventType::class);
    }
}