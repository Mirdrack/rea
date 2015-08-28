<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rea\Entities\User as User;

class UsersTest extends ApiTester
{
    use WithoutMiddleware;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_it_fetches_users()
    {
        $this->makeUser();

        $response = $this->getJson('/user');

        $this->assertResponseOk();
    }

    public function test_it_fetches_one_user()
    {
        $this->makeUser();
        $response = $this->getJson('/user/1');
        $user = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($user, 'name', 'email', 'created_at');
    }

    private function makeUser($userFields = [])
    {
        $user = array_merge([
            'name' => 'Clemente',
            'email' => 'clemente.estrada.p@gmail.com',
            'password' => 'sk8ersoul'

        ], $userFields);

        while($this->times--) User::create($user);
    }

    
}
