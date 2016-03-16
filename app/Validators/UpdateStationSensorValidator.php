<?php

namespace Rea\Validators;

class UpdateStationSensorValidator extends Validator
{
	
	protected $rules = [
                'label' => 'min:3',
                'notification_emails' => 'min:3',
                'notification_subject' => 'min:3',
                'notification_text' => 'min:3',
            ];
}