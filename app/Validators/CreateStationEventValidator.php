<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateStationEventValidator extends Validator
{
	
	protected $rules = [
                'user_id' => 'required|integer',
                'station_id' => 'required|integer',
	            'event_type_id' => 'required|integer',
	            'ip_address' => 'required|ip',
            ];
}