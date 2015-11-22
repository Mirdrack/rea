<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermission('admin', 'Admins');
        $this->createPermission('user', 'Users');
    }

    private function createPermission($name, $label)
    {
    	DB::table('roles')->insert([
            'name' => $name,
            'label' => $label,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
