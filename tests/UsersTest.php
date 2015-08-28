<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends ApiTester
{
    use WithoutMiddleware;
    
    public function test_it_fetches_users()
    {
        $this->make('User');
        $response = $this->getJson('/user', 'GET');
        $this->assertResponseOk();
    }

    public function test_it_fetches_one_user()
    {
        $this->make('User');
        $response = $this->getJson('/user/1', 'GET');
        $user = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($user, 'name', 'email', 'created_at');
    }

    public function test_404_if_user_not_found()
    {
        $this->make('User');
        $response = $this->getJson('/user/x');
        $this->assertResponseStatus(404);
    }

    public function test_it_creates_a_new_user_with_valid_parameters()
    {
        $this->getJson('/user', 'POST', $this->getStub());
        $this->assertResponseStatus(201);
    }

    public function test_it_fails_when_email_is_repeated()
    {
        $this->getJson('/user', 'POST', $this->getStub());
        $this->assertResponseStatus(201);
        $this->getJson('/user', 'POST', $this->getStub());
        $this->assertResponseStatus(409);
    }

    public function test_it_updates_a_user_whith_valid_parameters()
    {
        $newName = 'newName';
        $newEmail = 'new@email.com';
        $this->getJson('/user/1', 'PUT', ['name' => $newName, 'email' => $newEmail]);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('users', ['email' => $newEmail]);
        $this->notSeeInDatabase('users', ['email' => 'mirdrack@gmail.com']);
    }

    public function test_it_fails_when_try_to_update_with_bad_parameters()
    {
        // We gonna test the update with a short password
        $this->getJson('/user/1', 'PUT', ['password' => 'easy']);
        $this->assertResponseStatus(422);
    }

    protected function getStub()
    {
        return [
            'name' => 'Clemente',
            'email' => 'clemente.estrada.p@gmail.com',
            'password' => 'sk8ersoul'

        ];
    }
}
