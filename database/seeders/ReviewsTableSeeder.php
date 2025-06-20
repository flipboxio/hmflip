<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->truncate();

        DB::table('reviews')->insert([

            [
            'sender_id' => 2,
            'receiver_id' => 1,
            'booking_id' => 2,
            'property_id' => 1,
            'reviewer' => 'guest',
            'message' => 'Very responsive, excellent host. Clear communication!!!!! Nice and clean. Good location. Good value. Thank you.',
            'secret_feedback' => 'A great stay in a great place! Great location, super close to the train and with a superb host who was great at communicating with me and made check-in and my stay wonderful. Will definitely be staying again when I am in the city.',
            'improve_message' => 'It was an ok stay.',
            'rating' => 5,
            'accuracy' => 5,
            'accuracy_message' => NULL,
            'location' => 5,
            'location_message' => NULL,
            'communication' => 5,
            'checkin' => 5,
            'cleanliness' => 5,
            'cleanliness_message' => NULL,
            'amenities' => 5,
            'value' => 5,
            'value_message' => NULL,
            'house_rules' => NULL,
            'created_at' => '2020-12-03 00:52:34',
            'updated_at' => '2020-12-03 00:52:49'
            ],
                        
            [
            'sender_id' => 1,
            'receiver_id' => 2,
            'booking_id' => 4,
            'property_id' => 5,
            'reviewer' => 'host',
            'message' => 'Very great everything. Highly recommend',
            'secret_feedback' => 'great place to stay!',
            'improve_message' => NULL,
            'rating' => 5,
            'accuracy' => NULL,
            'accuracy_message' => NULL,
            'location' => NULL,
            'location_message' => NULL,
            'communication' => 5,
            'checkin' => NULL,
            'cleanliness' => 5,
            'cleanliness_message' => NULL,
            'amenities' => NULL,
            'value' => NULL,
            'value_message' => NULL,
            'house_rules' => 5,
            'created_at' => '2020-12-03 00:52:53',
            'updated_at' => '2020-12-03 00:52:53'
            ]

        ]);
    }
}
