<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChartTest extends ApiTester
{
    use WithoutMiddleware;
    
    public function test_it_retrieves_dynamic_level_chart_values_by_day()
    {
    	$this->fillReads();

        $data = $this->getStub('day', 'dynamic_level');
        $response = $this->getJson('chart/generate', 'POST', $data);
        $this->assertResponseStatus(200);
        $data = $response->data;
        $this->assertObjectHasAttributes($data, 'values', 'key', 'color', 'strokeWidth', 'area');
    }

    public function test_it_retrieves_voltage_chart_values_by_day()
    {
        $this->fillReads();

        $data = $this->getStub('day', 'voltage');
        $response = $this->getJson('chart/generate', 'POST', $data);
        $this->assertResponseStatus(200);
        $data = $response->data;
        $this->assertObjectHasAttributes($data, 'values', 'key', 'color', 'strokeWidth', 'area');
    }

    public function test_it_retrieves_current_chart_values_by_day()
    {
        $this->fillReads();

        $data = $this->getStub('day', 'current');
        $response = $this->getJson('chart/generate', 'POST', $data);
        $this->assertResponseStatus(200);
        $data = $response->data;
        $this->assertObjectHasAttributes($data, 'values', 'key', 'color', 'strokeWidth', 'area');
    }

    public function test_it_retrieves_power_chart_values_by_day()
    {
        $this->fillReads();

        $data = $this->getStub('day', 'power');
        $response = $this->getJson('chart/generate', 'POST', $data);
        $this->assertResponseStatus(200);
        $data = $response->data;
        $this->assertObjectHasAttributes($data, 'values', 'key', 'color', 'strokeWidth', 'area');
    }

    /*public function test_it_no_data_on_dynamic_level_chart_by_day()
    {
    	$data = $this->getStub('day');
        $response = $this->getJson('/chart/dynamic-level-chart', 'POST', $data);
        $this->assertResponseStatus(200);
        $data = $response->data;
        $this->assertObjectHasAttributes($data, 'error');
        $this->assertSame($data->error, 'No reads available for the interval given.');
    }*/

    protected function getStub($lapse, $column)
    {
        return [
            'station_id' => 1,
            'lapse' => $lapse,
            'start' => date('Y-m-d', time()),
            'end' => date('Y-m-d', time()),
            'column' => $column
        ];
    }

    protected function fillReads()
    {
    	$readClass = self::ENTITIES_PATH.'Read';
    	$time = time();
    	for ($cont = 0; $cont < 300; $cont ++)
    	{ 
    		$data = $this->getReadStub($time);
    		$Read = new $readClass;
			$Read->insert($data);
    		$time = $time + (15 * 60); // We add 15 minutes for the new read
    	}
    } 

    protected function getReadStub($time)
    {
    	return [
    		'station_id' => 1,
			'dynamic_level' => $this->createDecimalData(50, 250),
			'voltage' => $this->createDecimalData(380, 440),
			'current' => $this->createDecimalData(15, 30),
			'power' => $this->createDecimalData(250, 300),
            'created_at' => date('Y-m-d H:i:s', $time),
            'updated_at' => date('Y-m-d H:i:s', $time),
    	];
    }

    protected function createDecimalData($min, $max)
    {
        return rand($min * 10, $max * 10) / 10;
    }
}
