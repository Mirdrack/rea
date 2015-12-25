<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTest extends ApiTester
{

    public function test_it_creates_a_new_session_with_valid_parameters()
    {
        $data = $this->getStub();
        $response = $this->getJson('/login', 'POST', $data);
        $this->assertResponseStatus(200);
        $this->assertObjectHasAttributes($response->data, 'token');
    }

    public function test_it_401_when_try_login_with_invalid_parameters()
    {
        $data = $this->getInvalidStub();
        $response = $this->getJson('/login', 'POST', $data);
        $this->assertResponseStatus(401);
        $this->assertEquals($response->error, 'Invalid credentials.');
    }

    protected function getStub()
    {
        return [
            'email' => 'mirdrack@gmail.com',
            'password' => 'admin',
        ];
    }

    protected function getInvalidStub()
    {
        return [
            'email' => 'mirdrack@gmail.com',
            'password' => 'Invalid Password'
        ];
    }
}
