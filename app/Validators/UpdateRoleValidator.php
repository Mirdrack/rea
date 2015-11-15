<?php

namespace Rea\Validators;

class UpdateRoleValidator extends Validator
{
	
	protected $rules = [
                'label' => 'min:3',
            ];
}