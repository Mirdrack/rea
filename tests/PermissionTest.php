<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermissionTest extends ApiTester
{

	use WithoutMiddleware;
    
    public function test_it_fetch_all_permissions()
    {
    	$this->times(3)->make('Permission');
        $response = $this->getJson('/permission', 'GET');
        $this->assertResponseOk();
    }

    public function test_it_fetch_one_permission()
    {
        $this->times(3)->make('Permission');
        $response = $this->getJson('/permission/2', 'GET');
        $permission = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($permission, 'name', 'label', 'created_at');
    }

    public function test_it_404_if_permission_not_found()
    {
        $this->times(3)->make('Permission');
        $response = $this->getJson('/permission/500'); // We search for a very large number
        $this->assertResponseStatus(404);
    }

    public function test_it_updates_a_permission_whith_valid_parameters()
    {
        $this->make('Permission');
        $newLabel = 'New Label';
        $this->getJson('/permission/1', 'PUT', ['label' => $newLabel]);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('permissions', ['label' => $newLabel]);
    }

    public function test_it_fails_when_try_to_update_with_invalid_parameters()
    {
        // We gonna test the update with a short label
        $this->getJson('/user/1', 'PUT', ['password' => 'NO']);
        $this->assertResponseStatus(422);
    }

    protected function getStub()
    {
        $permission = $this->fake->word; 
        return [
            'name' => $permission,
            'label' => $permission,
        ];
    }

}
