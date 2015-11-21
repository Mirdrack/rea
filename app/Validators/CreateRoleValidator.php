<?php 
namespace Rea\Validators;

/**
* 
*/
class CreateRoleValidator extends Validator
{
	
	protected $rules = [
                'name' => 'required|unique:roles|min:3',
                'label' => 'required|min:3',
            ];
}