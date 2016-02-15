<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateStationAlarmValidator extends Validator
{
	
	protected $rules = [
                'station_id' => 'required|integer',
	            'alarm_type_id' => 'required|integer',
            ];
}