<?php

use Illuminate\Database\Seeder;
use Rea\Entities\Read;

class ReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = time() - (60 * 60 * 24) * 31;
        for ($cont = 0; $cont < 96 * 31 ; $cont++) 
        { 
        	$this->createRead(1, $time);
            $time += 60 * 15;
        }
    }

    private function createRead($station_id, $time)
    {
    	Read::insert([
			'station_id' => $station_id,
			'dynamic_level' => $this->createDecimalData(50, 250),
			'voltage' => $this->createDecimalData(380, 440),
			'current' => $this->createDecimalData(15, 30),
			'power' => $this->createDecimalData(250, 300),
            'created_at' => date('Y-m-d H:i:s', $time),
            'updated_at' => date('Y-m-d H:i:s', $time),
        ]);
    }

    private function createDecimalData($min, $max)
    {
    	return rand ($min * 10, $max * 10) / 10;
    }
}
