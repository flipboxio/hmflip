<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_admin')->truncate();

        DB::table('role_admin')->insert([
              ['admin_id' => 1, 'role_id' => 1],
              

        ]);
    }
}
