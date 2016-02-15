<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationEventTest extends ApiTester
{
    use WithoutMiddleware;

    public function test_it_creates_new_station_event_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
    }

    protected function getStub($stationId = 1, $alarmTypeId = 1)
    {
        return [
            'user_id' => 1,
            'station_id' => $stationId,
            'event_type_id' => $alarmTypeId,
            'ip_address' => '127.0.0.1',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
    }
}
