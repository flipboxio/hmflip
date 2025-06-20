<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;

class FavouritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favourites')->truncate();
        DB::table('favourites')->insert([
        		['property_id' => '1', 'user_id' => '2', 'status' => 'Active', 'created_at' => NULL, 'updated_at' => NULL],
        	]);
    }
}
