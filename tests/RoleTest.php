<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends ApiTester
{
    use WithoutMiddleware;

    public function test_it_fetches_roles()
    {
        $this->times(3)->make('Role');
        $response = $this->getJson('/role', 'GET');
        $this->assertResponseOk();
    }

    public function test_it_fetches_one_role()
    {
        $this->times(3)->make('Role');
        $response = $this->getJson('/role/2', 'GET');
        $role = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($role, 'name', 'label', 'created_at', 'permissions');
    }

    public function test_it_creates_new_user_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/role', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('roles', ['name' => $data['name'], 'label' => $data['label']]);
    }

    public function test_it_fails_when_name_is_repeated()
    {
        $params = $this->getStub();
        $this->getJson('/role', 'POST', $params);
        $this->assertResponseStatus(201);
        // We gonna send the same parameters in order to get the error
        $this->getJson('/role', 'POST', $params);
        $this->assertResponseStatus(422);
    }

    public function test_it_give_permission()
    {
    	$roleClass = self::ENTITIES_PATH.'Role';
    	$permissionClass = self::ENTITIES_PATH.'Permission';
    	
    	$this->make('Permission', ['name' => 'new-permission', 'label' => 'New Permission']);
    	$this->make('Role', ['name' => 'new-role', 'label' => 'New Role']);

        $role = $roleClass::where('name', 'new-role')->first();
        $permission = $permissionClass::where('name', 'new-permission')->first();

        $url = '/role/give-permission/'.$role->id.'/'.$permission->id;
        $response = $this->getJson($url, 'POST');
        $this->assertResponseOk();
        $this->assertEquals($response->message, 'Permission gived');
    	$this->seeInDatabase('permission_role', ['permission_id' => $permission->id, 'role_id' => $role->id]);
    }

    public function test_it_retrieve_permission()
    {
        $roleId = 1;
        $permissionId = 2;
        $url = '/role/retrieve-permission/'.$roleId.'/'.$permissionId;
        $response = $this->getJson($url, 'POST');
        $this->assertResponseOk();
        $this->assertEquals($response->message, 'Permission retrieved');
        $this->notSeeInDatabase('permission_role', ['permission_id' => $permissionId, 'role_id' => $roleId]);
    }

    public function test_it_update_a_role_label_with_valid_parameters()
    {
    	$this->make('Role');
        $newLabel = 'New Role Label';
        $this->getJson('/role/1', 'PUT', ['label' => $newLabel]);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('roles', ['label' => $newLabel]);
    }

    protected function getStub()
    {
        $role = $this->fake->word; 
        return [
            'name' => $role,
            'label' => $role,
        ];
    }
}
