<?php

namespace Rea\Validators;

/**
* 
*/
class PasswordRecoveryValidator extends Validator
{
	
	protected $rules = [
                'email' => 'required|email'
            ];
}