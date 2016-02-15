<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Clemente',
            'email' => 'mirdrack@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('users')->insert([
            'name' => 'Alejandro Alvarado',
            'email' => 'alexalvaradof@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('users')->insert([
            'name' => 'Reservorio 2',
            'email' => 'reservorio@gmega.com',
            'password' => bcrypt('admin'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
