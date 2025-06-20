<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties')->truncate();
    	
        DB::table('properties')->insert([
            
            [
                'name' => 'Hampton Inn',
                'slug' => 'hampton-inn',
                'host_id' => 1,
                'bedrooms' => 10,
                'beds' => 10,
                'bed_type' => 1,
                'bathrooms' => 8.00,
                'amenities' => '1,2,4,5,7,9,10,29,30,31',
                'property_type' => 1,
                'space_type' => 1,
                'accommodates' => 16,
                'booking_type' => 'request',
                'cancellation' => 'Flexible',
                'status' => 'Listed',
                'recomended' => 1,
                'created_at' => NULL,
                'updated_at' => NULL
                ],
                                 
                [
                'name' => 'North Sydney Harbourview Hotel',
                'slug' => 'north-sydney-harbourview-hotel',
                'host_id' => 1,
                'bedrooms' => 10,
                'beds' => 15,
                'bed_type' => 2,
                'bathrooms' => 8.00,
                'amenities' => '1,3,4,5,6,7,8,9,10,27,28',
                'property_type' => 2,
                'space_type' => 2,
                'accommodates' => 15,
                'booking_type' => 'request',
                'cancellation' => 'Flexible',
                'status' => 'Listed',
                'recomended' => 1,
                'created_at' => NULL,
                'updated_at' => NULL
                ],    
                            
                [
                'name' => 'Hotel Paris Rivoli',
                'slug' => 'hotel-paris-rivoli',
                'host_id' => 1,
                'bedrooms' => 10,
                'beds' => 16,
                'bed_type' => 3,
                'bathrooms' => 8.00,
                'amenities' => '1,2,4,5,6,11,12,13,14,17,18,19,21',
                'property_type' => 3,
                'space_type' => 3,
                'accommodates' => 10,
                'booking_type' => 'request',
                'cancellation' => 'Flexible',
                'status' => 'Listed',
                'recomended' => 1,
                'created_at' => NULL,
                'updated_at' => NULL
                ],          
                            
                [
                'name' => 'K+K Picasso',
                'slug' => 'k-k-picasso',
                'host_id' => 2,
                'bedrooms' => 10,
                'beds' => 10,
                'bed_type' => 4,
                'bathrooms' => 8.00,
                'amenities' => '1,3,4,5,6,7,10,11,21,22,23,24,25,26,27,28,29',
                'property_type' => 5,
                'space_type' => 1,
                'accommodates' => 10,
                'booking_type' => 'request',
                'cancellation' => 'Flexible',
                'status' => 'Listed',
                'recomended' => 1,
                'created_at' => NULL,
                'updated_at' => NULL
                ],
                                     
                [
                'name' => 'CONTACT APEX HOTELS',
                'slug' => 'contact-apex-hotels',
                'host_id' => 2,
                'bedrooms' => 5,
                'beds' => 10,
                'bed_type' => 6,
                'bathrooms' => 8.00,
                'amenities' => '1,3,4,9,10,11,17,18,19,20,21',
                'property_type' => 6,
                'space_type' => 2,
                'accommodates' => 10,
                'booking_type' => 'request',
                'cancellation' => 'Flexible',
                'status' => 'Listed',
                'recomended' => 1,
                'created_at' => NULL,
                'updated_at' => NULL
                ]
        ]);
    }
}
