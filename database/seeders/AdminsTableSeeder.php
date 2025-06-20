<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->truncate();
    	
        DB::table('admin')->insert([
        		['username' => 'admin', 'email' => 'admin@techvill.net', 'password' => '$2y$10$cS3WooR/tPPQ42qvo1NqB.i8crb.30NLYF3I05JyPDr/JYR.tqwMe', 'profile_image' => NULL, 'status' => 'active', 'remember_token' => NULL, 'created_at' => NULL, 'updated_at' => NULL],
        		
        	]);
    }
}
