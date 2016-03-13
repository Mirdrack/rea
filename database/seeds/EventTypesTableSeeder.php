<?php

use Illuminate\Database\Seeder;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->insert([
			'label' => 'Encendido de pozo',
			'description' => 'Se ha encendido el pozo a travez del portal web',
        ]);

        DB::table('event_types')->insert([
			'label' => 'Apagado de pozo',
			'description' => 'Se ha apagado el pozo a travez del portal web',
        ]);

        DB::table('event_types')->insert([
			'label' => 'Encendido de alarma puerta pozo',
			'description' => 'Se ha encendido la alarma de la puerta del pozo a travez del portal web',
        ]);

        DB::table('event_types')->insert([
			'label' => 'Apagado de alarma puerta pozo',
			'description' => 'Se ha apagado la alarma de la puerta del pozo a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Encendido de alarma movimiento',
            'description' => 'Se ha encendido la alarma de movimiento a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Apagado de alarma movimiento',
            'description' => 'Se ha apagado la alarma de movimiento a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Encendido de alarma puerta irrigación',
            'description' => 'Se ha encendido la alarma de la puerta irrigación a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Apagado de alarma puerta irrigación',
            'description' => 'Se ha apagado la alarma de la puerta irrigación a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Encendido de alarma movimiento irrigación',
            'description' => 'Se ha encendido la alarma de movimiento irrigación a travez del portal web',
        ]);

        DB::table('event_types')->insert([
            'label' => 'Apagado de alarma movimiento irrigación',
            'description' => 'Se ha apagado la alarma de movimiento irrigación a travez del portal web',
        ]);
    }
}
