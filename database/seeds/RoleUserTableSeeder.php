<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// roleId 1 == admin, userId 1 == mirdrack 
        $this->createRoleUser(1, 1);
    }

    private function createRoleUser($roleId, $userId)
    {
    	DB::table('role_user')->insert([
            'role_id' => $roleId,
            'user_id' => $userId,
        ]);
    }
}
