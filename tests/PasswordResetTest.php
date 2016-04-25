<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordRestTest extends ApiTester
{
    
    public function test_it_ask_for_password_reset_with_valid_email()
    {
        // First, we set our email
        $email = 'mirdrack@gmail.com';
        
        // Then, We ask for reset
        $postData = ['email' => $email];
        $response = $this->getJson('password/recovery', 'POST', $postData);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('password_resets', ['email' => 'mirdrack@gmail.com']);

        // This is only for the test enviroment
        $token = 'randomWord';
        DB::table('password_resets')
                ->where('email', 'mirdrack@gmail.com')
                ->update([
                    'token' => $token,
                ]);
        $this->seeInDatabase('password_resets', ['email' => 'mirdrack@gmail.com', 'token' => $token]);

        // Then attempt for rest the password
        $newPassword = 'NewPassword';
        $postData = ['password' => $newPassword, 'token' => $token, 'email' => $email];
        $this->getJson('password/reset', 'POST', $postData);
        $this->assertResponseOk(); // We should get a 200 response
        // And the record for the rest token should be deleted
        $this->notSeeInDatabase('password_resets', ['email' => 'mirdrack@gmail.com']);

        // Finnaly, We call our login method to check our function
        //$loginResponse = $this->login($newPassword);
    }

    protected function login($password = null)
    {
        $postData = $this->getStub($password);
        $response = $this->getJson('/login', 'POST', $postData);
        $this->assertResponseOk();
        return $response;
    }

    protected function getStub($password)
    {
        if($password == null) 
            $password = 'admin';

        return [
            'email' => 'mirdrack@gmail.com',
            'token' => 'admin',
        ];
    }
}
