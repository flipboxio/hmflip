<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LeaseTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('lease_type')->truncate();

        \DB::table('lease_type')->insert([
//            ['name' => 'Booking', 'slug' => 'booking', 'description' => 'Período curto estilo AirBnB', 'status' => 'Active'],
            ['name' => 'Anual', 'slug' => 'anual', 'description' => 'Período anual de contrato', 'status' => 'Active'],
        ]);
    }
}
