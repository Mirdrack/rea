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
			'label' => 'Encendido de alarma',
			'description' => 'Se ha encendido la alarma a travez del portal web',
        ]);

        DB::table('event_types')->insert([
			'label' => 'Apagado de alarma',
			'description' => 'Se ha apagado la alarma a travez del portal web',
        ]);
    }
}
