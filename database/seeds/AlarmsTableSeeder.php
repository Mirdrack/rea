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
			'label' => 'Alarma en el pozo',
			'description' => 'Se ha disparado la Alarma del pozo',
        ]);

        DB::table('alarms')->insert([
			'label' => 'Fallo variador',
			'description' => 'Fallo en variador',
        ]);
    }
}
