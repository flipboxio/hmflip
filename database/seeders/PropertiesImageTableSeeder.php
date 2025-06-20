<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_photos')->truncate();

        DB::table('property_photos')->insert([

            [
            'property_id' => 1,
            'photo' => 'property-1.jpg',
            'cover_photo' => 1,
            'serial' => 0
            ],

            [
            'property_id' => 2,
            'photo' => 'property-6.jpg',
            'cover_photo' => 1,
            'serial' => 0
            ],

            [
            'property_id' => 3,
            'photo' => 'property-10.jpg',
            'cover_photo' => 1,
            'serial' => 0
            ],

            [
            'property_id' => 4,
            'photo' => 'property-14.jpg',
            'cover_photo' => 1,
            'serial' => 0
            ],

            [
            'property_id' => 5,
            'photo' => 'property-18.jpg',
            'cover_photo' => 1,
            'serial' => 0
            ]


        ]);
    }
}
