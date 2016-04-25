<?php

namespace Rea\Validators;

/**
* 
*/
class PasswordResetValidator extends Validator
{
	
	protected $rules = [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'min:6',
            ];
}