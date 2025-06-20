<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AmenityTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('amenity_type')->truncate();
    	
        DB::table('amenity_type')->insert([
        		['name' => 'Common Amenities', 'description' => NULL],
  				['name' => 'Safety Amenities', 'description' => NULL],
        	]);
    }
}
