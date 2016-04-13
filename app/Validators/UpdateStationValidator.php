<?php

namespace Rea\Validators;

/**
* 
*/
class UpdateStationValidator extends Validator
{
	
	protected $rules = [
                'name' => 'min:3',
            ];
}