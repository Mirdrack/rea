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
        $this->assertObjectHasAttributes($role, 'name', 'label', 'created_at');
    }

    public function test_it_give_permission()
    {
    	$roleClass = self::ENTITIES_PATH.'Role';
    	$permissionClass = self::ENTITIES_PATH.'Permission';
    	
    	$this->times(5)->make('Role');
    	$this->times(3)->make('Permission');
    	$this->make('Permission', ['name' => 'edit-user', 'label' => 'Edit User']);
    	$this->make('Role', ['name' => 'admin', 'label' => 'Administrator']);
    	
    	$role = $roleClass::where('name', 'admin')->first();
    	$permission = $permissionClass::where('name', 'edit-user')->first();
    	$role->givePermissionTo($permission);
    	$this->seeInDatabase('permission_role', ['permission_id' => $permission->id, 'role_id' => $role->id]);
    }

    public function test_it_retrieve_permission()
    {
    	$roleClass = self::ENTITIES_PATH.'Role';
    	$permissionClass = self::ENTITIES_PATH.'Permission';
    	
    	$this->times(5)->make('Role');
    	$this->times(3)->make('Permission');
    	$this->make('Permission', ['name' => 'edit-user', 'label' => 'Edit User']);
    	$this->make('Role', ['name' => 'admin', 'label' => 'Administrator']);
    	
    	$role = $roleClass::where('name', 'admin')->first();
    	$permission = $permissionClass::where('name', 'edit-user')->first();
    	$role->givePermissionTo($permission);
    	$this->seeInDatabase('permission_role', ['permission_id' => $permission->id, 'role_id' => $role->id]);

    	$role->retrievePermissionTo($permission);
    	$this->notSeeInDatabase('permission_role', ['permission_id' => $permission->id, 'role_id' => $role->id]);

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
