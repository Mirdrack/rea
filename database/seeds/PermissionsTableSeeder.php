<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermission('list-users', 'List Users');
        $this->createPermission('create-users', 'Create Users');
        $this->createPermission('edit-users', 'Edit Users');
        $this->createPermission('view-users', 'View Users');
        $this->createPermission('delete-users', 'Delete Users');

        $this->createPermission('list-roles', 'List Groups');
        $this->createPermission('create-roles', 'Create Groups');
        $this->createPermission('edit-roles', 'Edit Groups');
        $this->createPermission('view-roles', 'View Groups');
        $this->createPermission('delete-roles', 'Delete Groups');
        
        $this->createPermission('list-permissions', 'List Resources');
        $this->createPermission('view-roles', 'View Resources');

    }

    private function createPermission($name, $label)
    {
    	DB::table('permissions')->insert([
            'name' => $name,
            'label' => $label,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
