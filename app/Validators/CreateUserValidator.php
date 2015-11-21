<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateUserValidator extends Validator
{
	
	protected $rules = [
                'name' => 'required|min:3',
                'password' => 'required|min:6',
                'email' => 'email|unique:users'
            ];
}