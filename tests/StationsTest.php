<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationsTest extends ApiTester
{
    use WithoutMiddleware;
    
    public function test_it_fetches_stations()
    {
        $this->times(5)->make('Station');
        $response = $this->getJson('/station', 'GET');
        $this->assertResponseOk();
        $this->assertCount(6, $response->data); // 6 Cause we already have one
    }

    public function test_it_fetches_one_station()
    {
        // We already have one station on our database, result form the initial seeder
        // So we gonna try to get that station
        $response = $this->getJson('/station/1', 'GET');
        $station = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($station, 'id', 'name', 'created_at', 'reads');
        $this->assertCount(5, $station->reads);
    }

    protected function getStub()
    {
        return [
            'name' => $this->fake->word,
        ];
    }
}
