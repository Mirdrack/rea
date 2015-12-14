<?php

use Illuminate\Database\Seeder;

class ReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($cont = 0; $cont < 15 ; $cont++) 
        { 
        	$this->createRead(1);
        }
    }

    private function createRead($station_id)
    {
    	DB::table('reads')->insert([
			'station_id' => $station_id,
			'dynamic_level' => $this->createDecimalData(50, 250),
			'voltage' => $this->createDecimalData(380, 440),
			'current' => $this->createDecimalData(15, 30),
			'power' => $this->createDecimalData(250, 300),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }

    private function createDecimalData($min, $max)
    {
    	return rand ($min*10, $max*10) / 10;
    }
}
