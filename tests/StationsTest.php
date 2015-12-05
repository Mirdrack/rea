<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationsTest extends ApiTester
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fetches_one_station()
    {
        // We already have one user on our database, result form the initial seeder
        // So we gonna try to get that user
        $response = $this->getJson('/station/1', 'GET');
        $station = $response->data;
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($station, 'id', 'name', 'created_at', 'reads');
    }
}
