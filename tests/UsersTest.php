<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $this->make('User');

        $response = $this->getJson('/user');

        $this->assertResponseOk();
    }

    public function test_it_fetches_one_user()
    {
        $this->make('User');
        $response = $this->getJson('/user/1');
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

    protected function getStub()
    {
        return [
            'name' => 'Clemente',
            'email' => 'clemente.estrada.p@gmail.com',
            'password' => 'sk8ersoul'

        ];
    }

    /*private function makeUser($userFields = [])
    {
        $user = array_merge([
            'name' => 'Clemente',
            'email' => 'clemente.estrada.p@gmail.com',
            'password' => 'sk8ersoul'

        ], $userFields);

        while($this->times--) User::create($user);
    }*/

    
}
