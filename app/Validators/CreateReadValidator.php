<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateReadValidator extends Validator
{
	
	protected $rules = [
                'station_id' => 'required|integer',
	            'dynamic_level' => 'required',
	            'voltage' => 'required',
	            'current' => 'required',
	            'power' => 'required',
            ];
}