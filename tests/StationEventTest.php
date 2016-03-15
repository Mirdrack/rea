<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationEventTest extends ApiTester
{
    use WithoutMiddleware;

    /*public function test_it_fetch_a_page_of_events_with_valid_parameters()
    {
        $response = $this->getJson('/station-event', 'GET');
        $this->assertResponseStatus(200);
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($response->data, 'station_events', 'paginator');
    }

    public function test_it_creates_new_station_event_with_valid_paramters()
    {
        $data = $this->getStub();
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
    }*/

    public function test_it_creates_new_turn_off_alarm_event_with_valid_paramters()
    {
        $alarmCooldown = 100;
        $data = $this->getStub(1, 4); // alarm_type = 4 | Alarm deactivated (Puerta Pozo)
        $data['alarm_cooldown'] = $alarmCooldown;
        $response = $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        unset($data['alarm_cooldown']);
        $this->seeInDatabase('station_events', $data);
        $sensorRecord = [
            'id' => 1, 
            'alarm_activated' => false, 
            'alarm_cooldown' => $alarmCooldown,
        ];
        $this->seeInDatabase('station_sensors', $sensorRecord);
        $this->assertObjectHasAttributes($response->data, 'station_event', 'station_sensor');
    }

    public function test_it_creates_new_turn_on_alarm_event_with_valid_paramters()
    {
        $data = $this->getStub(1, 3); // alarm_type = 3 | Alarm activated (Puerta Pozo)
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
        $this->seeInDatabase('station_sensors', ['id' => 1, 'alarm_activated' => true ]);
    }

    public function test_it_creates_new_turn_on_station_event_with_valid_paramters()
    {
        $data = $this->getStub(1, 1); // alarm_type = 3 | Alarm activated
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
        $this->seeInDatabase('stations', ['id' => 1, 'status' => true ]);
    }

    public function test_it_creates_new_turn_off_station_event_with_valid_paramters()
    {
        $data = $this->getStub(1, 2); // alarm_type = 3 | Alarm activated
        $this->getJson('/station-event', 'POST', $data);
        $this->assertResponseStatus(201);
        $this->seeInDatabase('station_events', $data);
        $this->seeInDatabase('stations', ['id' => 1, 'status' => false ]);
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
