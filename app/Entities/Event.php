<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['station_id', 'alarm_id']; 

    public function setUpdatedAtAttribute($value)
    {
        // Do nothing because we don't need the updated_at attribute.
    }
}