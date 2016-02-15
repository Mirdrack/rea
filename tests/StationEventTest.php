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

    public function test_it_creates_new_turn_on_alarm_event_with_valid_paramters()
    {
        $data = $this->getStub(1, 3); // alarm_type = 3 | Alarm activated
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
        $this->seeInDatabase('stations', ['id' => 1, 'alarm_activated' => true ]);
    }

    protected function getStub($stationId = 1, $eventTypeId = 1)
    {
        return [
            'user_id' => 1,
            'station_id' => $stationId,
            'event_type_id' => $eventTypeId,
            'ip_address' => '127.0.0.1',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
    }
}
