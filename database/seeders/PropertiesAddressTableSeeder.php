<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_address')->truncate();

        DB::table('property_address')->insert([

            [
            'property_id' => 1,
            'address_line_1' => 'New York City Hall, New York, NY 10007, USA',
            'address_line_2' => '851 8th Ave, New York, NY, US, 10019',
            'latitude' => '40.7127461',
            'longitude' => '-74.00597399999998',
            'city' => 'New York',
            'state' => 'New York',
            'country' => 'US',
            'postal_code' => '10007'
            ],

            [
            'property_id' => 2,
            'address_line_1' => 'MLC Centre, 108 King St, Sydney NSW 2000, Australia',
            'address_line_2' => NULL,
            'latitude' => '-33.8686949',
            'longitude' => '151.2092424',
            'city' => 'Sydney',
            'state' => 'New South Wales',
            'country' => 'AU',
            'postal_code' => '2000'
            ],

            [
            'property_id' => 3,
            'address_line_1' => '19 Rue de Rivoli, 75004 Paris, France',
            'address_line_2' => NULL,
            'latitude' => '48.8559431',
            'longitude' => '2.3573452000000543',
            'city' => 'Paris',
            'state' => 'Île-de-France',
            'country' => 'FR',
            'postal_code' => '75004'
            ],

            [
            'property_id' => 4,
            'address_line_1' => 'Passeig de Picasso, 26, 08003 Barcelona, Spain',
            'address_line_2' => NULL,
            'latitude' => '41.3866227',
            'longitude' => '2.184072199999946',
            'city' => 'Barcelona',
            'state' => 'Catalunya',
            'country' => 'ES',
            'postal_code' => '08003'
            ],

            [
            'property_id' => 5,
            'address_line_1' => '12 Stacey St, London WC2H, UK',
            'address_line_2' => NULL,
            'latitude' => '51.5142805',
            'longitude' => '-0.12846539999998186',
            'city' => 'London',
            'state' => 'England',
            'country' => 'GB',
            'postal_code' => 'WC2H'
            ]
        ]);
    }
}
