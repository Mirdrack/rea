<?php

namespace Rea\Validators;

/**
* Validator class to use it on Test
*/
class StubValidator extends Validator
{
	
	/**
	 * Validation stub for testing
	 * @var array
	 */
	protected $rules = [
                'name' => 'min:3|alpha',
                'password' => 'min:6|confirmed',
                'email' => 'email|unique:users'
            ];
}