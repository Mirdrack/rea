<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('PermissionsTableSeeder');
        $this->command->info('The Permissions table has been seeded!');
        $this->call('RolesTableSeeder');
        $this->command->info('The Roles table has been seeded!');
        $this->call('PermissionRoleTableSeeder');
        $this->command->info('Permissions and Roles tables has been joined!');
        $this->call('UsersTableSeeder');
        $this->command->info('The Users table has been seeded!');
        $this->call('RoleUserTableSeeder');
        $this->command->info('Roles and Users tables has been joined!');

        Model::reguard();
    }
}
