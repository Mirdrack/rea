<?php

use Illuminate\Database\Seeder;

class Stations2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')
                ->where('id', 1)
                ->update([
                    'notification_phones' => '3333688082, 3315296568',
                    'notification_emails' => 'alexalvaradof@gmail.com, soporte@aitanastudios.com',
                ]);
    }
}
