<?php

use Illuminate\Database\Seeder;

class AlarmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alarms')->insert([
			'label' => 'Puerta abierta',
			'description' => 'Puerta abierta',
        ]);

        DB::table('alarms')->insert([
			'label' => 'Fallo variador',
			'description' => 'Fallo variador',
        ]);
    }
}
