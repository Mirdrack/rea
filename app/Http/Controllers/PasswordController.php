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
use Rea\Validators\PasswordResetValidator;

use Faker\Factory as FakerFactory;

class PasswordController extends ApiController
{
    protected $faker;
    protected $passwordResetValidator;
    protected $passwordRecoveryValidator;

    public function __construct(
        PasswordRecoveryValidator $passwordRecoveryValidator,
        PasswordResetValidator $passwordResetValidator)
    {
        $this->faker = FakerFactory::create();
        $this->passwordResetValidator = $passwordResetValidator;
        $this->passwordRecoveryValidator = $passwordRecoveryValidator;
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

            return $this->respondOk(null, 'An email with password rest instruction has been sent');
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
        $data = $request->all();
        $isValid = $this->passwordResetValidator->with($data)->passes();

        if(!$isValid)
            return $this->respondNotFound('Invalid');

        $email = $request->get('email');
        $token = $request->get('token');
        $newPassword = $request->get('password');

        $passwordReset = PasswordReset::where('email', $email)
                                        ->where('token', $token)
                                        ->first();
        if(!$passwordReset)
            return $this->respondUnprocessable('Invalid token');
        else
        {
            PasswordReset::where('email', $email)
                            ->where('token', $token)
                            ->delete();
            $user = User::where('email', $email)->first();
            $user->password = $newPassword;
            $user->save();
            return $this->respondOk(null, 'Password has been reseted');
        }
    }
}
