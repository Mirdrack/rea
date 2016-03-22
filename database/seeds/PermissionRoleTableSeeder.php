<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*// Id 1 == admin role
        $this->createPermissionRole(1, 1);  // list-users
        $this->createPermissionRole(2, 1);  // create-users
        $this->createPermissionRole(3, 1);  // edit-users
        $this->createPermissionRole(4, 1);  // view-users
        $this->createPermissionRole(5, 1);  // delete-users

        $this->createPermissionRole(6, 1);  // list-roles
        $this->createPermissionRole(7, 1);  // create-roles
        $this->createPermissionRole(8, 1);  // edit-roles
        $this->createPermissionRole(9, 1);  // view-roles
        $this->createPermissionRole(10, 1); // delete-roles
        
        $this->createPermissionRole(11, 1); // list-permissions
        $this->createPermissionRole(12, 1); // view-permissions*/

        // Id 1 == admin role
        $this->createPermissionRole(1, 1);  // users
        $this->createPermissionRole(2, 1);  // groups
        $this->createPermissionRole(3, 1);  // view-stations
        $this->createPermissionRole(4, 1);  // alarms-stations
        $this->createPermissionRole(5, 1);  // events-stations
        $this->createPermissionRole(6, 1);  // station-sensors
    }

    private function createPermissionRole($permissionId, $roleId)
    {
    	DB::table('permission_role')->insert([
            'permission_id' => $permissionId,
            'role_id' => $roleId,
        ]);
    }
}
