<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends ApiTester
{
    use WithoutMiddleware;

    public function test_it_creates_new_event_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('events', $data);
    }

    protected function getStub($stationId = 1, $alarmTypeId = 1)
    {
        return [
            'station_id' => $stationId,
            'alarm_id' => $alarmTypeId,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
    }
}
