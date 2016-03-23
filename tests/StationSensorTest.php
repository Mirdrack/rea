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

    public function test_it_updates_a_station_sensor_with_valid_parameters()
    {
        $newLabel = 'New Label';
        $newEmails = 'new@email.com, new2@email.com';
        $newEmailSubject = 'New Subject';
        $newEmailBody = 'New Email Body';
        $postData = [
            'label' => $newLabel,
            'notification_emails' => $newEmails,
            'notification_subject' => $newEmailSubject,
            'notification_text' => $newEmailBody,
        ];
        $this->getJson('/station-sensor/1', 'PUT', $postData);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('station_sensors', $postData);
        // $this->notSeeInDatabase('users', ['email' => 'mirdrack@gmail.com']);
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
