<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesDescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_description')->truncate();
    	
        DB::table('property_description')->insert([
            
            [
            'property_id' => 1,
            'summary' => 'A stay at Hampton Inn Times Square North places you in the heart of New York, walking distance from Studio 54 and Ed Sullivan Theater. This hotel is close to Broadway and Rockefeller Center.',
            'place_is_great_for' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'about_place' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'guest_can_access' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'interaction_guests' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'other' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'about_neighborhood' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.',
            'get_around' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et.'
            ], 
                        
            [
            'property_id' => 2,
            'summary' => 'The View Hotels comprise three hotels within Australia located in three of the most beautiful and exciting cities – Sydney, Melbourne and Brisbane.',
            'place_is_great_for' => NULL,
            'about_place' => NULL,
            'guest_can_access' => NULL,
            'interaction_guests' => NULL,
            'other' => NULL,
            'about_neighborhood' => NULL,
            'get_around' => NULL
            ],     
                        
            [
            'property_id' => 3,
            'summary' => 'Situated in the famous Marais district surrounded by boutiques, monuments and museums, the Hotel Paris Rivoli offers three-star accommodations in the most desirable part of Paris.',
            'place_is_great_for' => NULL,
            'about_place' => NULL,
            'guest_can_access' => NULL,
            'interaction_guests' => NULL,
            'other' => NULL,
            'about_neighborhood' => NULL,
            'get_around' => NULL
            ],
                                    
            [
            'property_id' => 4,
            'summary' => 'K+K Picasso offers 4-star elegance in Barcelona’s El Born district, directly opposite Parc de la Ciutadella and Barcelona Zoo on Passeig de Picasso. The hotel has avant-garde architecture, a rooftop pool with city views and is less than 15 minutes’ walk from La Rambla, Barceloneta Beach and the Gothic Quarter.',
            'place_is_great_for' => NULL,
            'about_place' => NULL,
            'guest_can_access' => NULL,
            'interaction_guests' => NULL,
            'other' => NULL,
            'about_neighborhood' => NULL,
            'get_around' => NULL,
            ],
                    
            [
            'property_id' => 5,
            'summary' => 'CONTACT APEX HOTELS',
            'place_is_great_for' => NULL,
            'about_place' => NULL,
            'guest_can_access' => NULL,
            'interaction_guests' => NULL,
            'other' => NULL,
            'about_neighborhood' => NULL,
            'get_around' => NULL
            ]
        ]);
    }
}
