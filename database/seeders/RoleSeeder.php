<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        Role::create([
            'id' => '1',
            'slug' => 'admin',
            'name' => 'Administrator',
            'created_at' => '2017-10-31 19:54:38',
            'updated_at' => '2017-10-31 19:54:38',
        ]);
    }
}
