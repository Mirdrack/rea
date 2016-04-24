<?php

namespace Rea\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\User;
use Rea\Entities\PasswordReset;

use Rea\Validators\PasswordRecoveryValidator;

use Faker\Factory as FakerFactory;

class PasswordController extends ApiController
{
    protected $faker;
    protected $passwordRecoveryValidator;

    public function __construct(PasswordRecoveryValidator $passwordRecoveryValidator)
    {
        $this->passwordRecoveryValidator = $passwordRecoveryValidator;
        $this->faker = FakerFactory::create();
    }

    /**
     * Store a newly created resource in storage.
     * That allows the user reset password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recovery(Request $request)
    {
        $data = $request->all();
        $isValid = $this->passwordRecoveryValidator->with($data)->passes();

        if(!$isValid)
            return $this->respondNotFound('Invalid');

        $email = $request->get('email');
        $user = User::where('email', $email)->first();
        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {   
            // We create an md5 token and record on the password_resets table
            $token = $this->faker->md5;
            $passwordReset = PasswordReset::create(['email' => $email, 'token' => $token]);
            
            // We send the email to the user
            $emailData = ['user' => $user, 'passwordReset' => $passwordReset];
            Mail::send('emails.password-update', $emailData, function ($m) use ($user) 
            {
                $m->from('aitanastudios@gmail.com', 'Sistema de Monitoreo');
                $m->to($user->email)->subject('Nuevo password');
            });

            return $this->respondCreated(null, 'An email with password rest instruction has been sent');
        }
    }

    /**
     * Reset the user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        // get request data
        // 
        // validate data
        
        // if not valid response with 404
        // 
        // if yes update password
        // 
        // response with 200
    }
}
