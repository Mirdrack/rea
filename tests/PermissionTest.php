<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermissionTest extends ApiTester
{

	use WithoutMiddleware;
    
    public function test_it_fetch_all_permissions()
    {
    	$this->make('Permission');
        $this->assertTrue(true);
        $response = $this->getJson('/permission', 'GET');
        $this->assertResponseOk();
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
