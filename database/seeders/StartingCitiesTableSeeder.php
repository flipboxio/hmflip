<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class StartingCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('starting_cities')->truncate();
        
        DB::table('starting_cities')->insert([
                ['name' => 'New York', 'image' => 'starting_city_1.jpg'],
                ['name' => 'Sydney', 'image' => 'starting_city_2.jpg'],
                ['name' => 'Paris', 'image' => 'starting_city_3.jpg'],
                ['name' => 'Barcelona', 'image' => 'starting_city_4.jpg'],
                ['name' => 'Berlin', 'image' => 'starting_city_5.jpg'],
                ['name' => 'Budapest', 'image' => 'starting_city_6.jpg'],
        ]);
    }
}
