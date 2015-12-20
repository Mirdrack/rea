<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadTest extends ApiTester
{

	use WithoutMiddleware;
    
    public function test_it_creates_new_read_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/read', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('roles', ['voltage' => $data['voltage'], 'power' => $data['power']]);
    }

    protected function getStub()
    {
        return [
            'station_id' => '1',
            'dynamic_level' => $this->createDecimalData(50, 250),
            'voltage' => $this->createDecimalData(380, 440),
            'current' => $this->createDecimalData(15, 30),
            'power' => $this->createDecimalData(250, 300),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
    }

    protected function createDecimalData($min, $max)
    {
        return rand ($min*10, $max*10) / 10;
    }
}
