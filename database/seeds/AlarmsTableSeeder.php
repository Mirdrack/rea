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
			'label' => 'Puerta abierta, pozo',
			'description' => 'Se ha disparado la alarma de puerta abierta en el pozo',
        ]);

        DB::table('alarm_types')->insert([
			'label' => 'Alarma de movimiento',
			'description' => 'Se ha disparado la alarma de movimiento afuera del pozo',
        ]);

        DB::table('alarm_types')->insert([
            'label' => 'Puerta abierta, cuarto de riego',
            'description' => 'Se ha disparado la alarma de puerta abierta en el cuarto de riego',
        ]);

        DB::table('alarm_types')->insert([
            'label' => 'Alarma de movimiento, cuarto riego',
            'description' => 'Se ha disparado la alarma de movimiento afuera del cuarto de riego',
        ]);
    }
}
