<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationSensorTest extends ApiTester
{
    use WithoutMiddleware;
    
    public function test_it_fetches_all_sensors()
    {
        $response = $this->getJson('/station-sensor', 'GET');
        $this->assertResponseOk();
    }

    /*protected function getStub()
    {
        return [
            'name' => $this->fake->name,
            'email' => $this->fake->email,
            'password' => $this->fake->password,
        ];
    }*/
}
