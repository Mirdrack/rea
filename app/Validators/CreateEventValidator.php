<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateEventValidator extends Validator
{
	
	protected $rules = [
                'station_id' => 'required|integer',
	            'alarm_id' => 'required|integer',
            ];
}