<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class StationAlarm extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'station_alarms';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['station_id', 'alarm_type_id']; 

    public function setUpdatedAtAttribute($value)
    {
        // Do nothing because we don't need the updated_at attribute.
    }
}