<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordTest extends ApiTester
{
    
    public function test_it_login_with_valid_paramters()
    {
        // We call our login method to get the Json Token
        $loginResponse = $this->login();
        $token = $loginResponse->data->token;

        // Now we check a protected url and expect a 200
        $url = '/user?token='.$token;
        $response = $this->getJson($url, 'GET');
        $this->assertResponseOk();
    }

    public function test_it_user_change_the_password_with_valid_parameters()
    {
        // We call our login method
        $loginResponse = $this->login();
        $token = $loginResponse->data->token;

        // Now we gonna change our password
        $postData = ['password' =>'sk8ersoul'];
        $url = '/user/change-password?token='.$token;
        $response = $this->getJson($url, 'POST', $postData);
        $this->assertResponseOk();
    }

    protected function login()
    {
        $postData = $this->getStub();
        $response = $this->getJson('/login', 'POST', $postData);
        $this->assertResponseOk();
        return $response;
    }

    protected function getStub()
    {
        return [
            'email' => 'mirdrack@gmail.com',
            'password' => 'admin',
        ];
    }
}
