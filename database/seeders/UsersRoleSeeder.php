<?php

namespace Database\Seeders;
use App\Models\UserRole;
use DB;
use Illuminate\Database\Seeder;

class UsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->truncate();
        $user_role = new UserRole();
        $user_role->role_id = 1;
        $user_role->user_id =1;
        $user_role->save();
    }
}
