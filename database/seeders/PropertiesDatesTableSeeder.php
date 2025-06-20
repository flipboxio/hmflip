<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesDatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_dates')->truncate();
    	
    }
}
