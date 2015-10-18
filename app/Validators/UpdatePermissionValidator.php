<?php

namespace Rea\Validators;

class UpdatePermissionValidator extends Validator
{
	
	protected $rules = [
                'label' => 'min:3',
            ];
}