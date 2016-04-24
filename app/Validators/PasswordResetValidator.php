<?php

namespace Rea\Validators;

/**
* 
*/
class PasswordResetValidator extends Validator
{
	
	protected $rules = [
                'name' => 'min:3',
                'password' => 'min:6',
                'email' => 'email'
            ];
}