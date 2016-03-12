<?php

use Illuminate\Database\Seeder;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('station_sensors')->insert([
            'station_id' => 1,
            'name' => 'Maya',
            'label' => 'Puerta Cuarto Variador',
            'alarm_activated' => false,
            'alarm_cooldown' => 0,
            'alarm_turned_off_at' => null,
            'notification_emails' => 'alexalvaradof@gmail.com, soporte@aitanastudios.com',
            'notification_subject' => 'Alarma. Puerta Cuarto Variador',
            'notification_text' => 'Alarma. Puerta Cuarto Variador',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('station_sensors')->insert([
            'station_id' => 1,
            'name' => 'Electra',
            'label' => 'Movimiento Poste',
            'alarm_activated' => false,
            'alarm_cooldown' => 0,
            'alarm_turned_off_at' => null,
            'notification_emails' => 'alexalvaradof@gmail.com, soporte@aitanastudios.com',
            'notification_subject' => 'Alarma. Movimiento Poste',
            'notification_text' => 'Alarma. Movimiento Poste',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('station_sensors')->insert([
            'station_id' => 1,
            'name' => 'Hestia',
            'label' => 'Puerta Cuarto Riego',
            'alarm_activated' => false,
            'alarm_cooldown' => 0,
            'alarm_turned_off_at' => null,
            'notification_emails' => 'alexalvaradof@gmail.com, soporte@aitanastudios.com',
            'notification_subject' => 'Alarma. Puerta Cuarto Riego',
            'notification_text' => 'Alarma. Puerta Cuarto Riego',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('station_sensors')->insert([
            'station_id' => 1,
            'name' => 'Aretusa',
            'label' => 'Movimiento Cuarto Riego',
            'alarm_activated' => false,
            'alarm_cooldown' => 0,
            'alarm_turned_off_at' => null,
            'notification_emails' => 'alexalvaradof@gmail.com, soporte@aitanastudios.com',
            'notification_subject' => 'Alarma. Movimiento Cuarto Riego',
            'notification_text' => 'Alarma. Movimiento Cuarto Riego',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
