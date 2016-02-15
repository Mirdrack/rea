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
        DB::table('alarm_types')->insert([
			'label' => 'Alarma en el pozo',
			'description' => 'Se ha disparado la Alarma del pozo',
        ]);

        DB::table('alarm_types')->insert([
			'label' => 'Fallo variador',
			'description' => 'Fallo en variador',
        ]);
    }
}
