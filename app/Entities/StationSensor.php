<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class StationSensor extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'station_sensors';

    protected $dates = ['created_at', 'updated_at', 'alarm_turned_off_at'];

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'station_id',
        'label',
        'notification_emails',
        'notification_subject',
        'notification_text'
    ]; 

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}