<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationAlarmTest extends ApiTester
{
    use WithoutMiddleware;

    public function test_it_creates_new_station_alarm_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/station-alarm', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_alarms', $data);
    }

    protected function getStub($stationId = 1, $alarmTypeId = 1)
    {
        return [
            'station_id' => $stationId,
            'alarm_type_id' => $alarmTypeId,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
    }
}
