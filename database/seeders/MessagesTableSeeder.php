<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->truncate();
    	
        DB::table('messages')->insert( [
            [
            'id' => 1,
            'property_id' => 1,
            'booking_id' => 1,
            'sender_id' => 2,
            'receiver_id' => 1,
            'message' => 'Hey, I want to stay at this home.',
            'type_id' => 4,
            'read' => 1,
            'archive' => 0,
            'star' => 0,
            'created_at' => '2020-12-03 00:14:57',
            'updated_at' => '2021-06-23 17:42:01'
            ],
                        
            [
            'id' => 2,
            'property_id' => 5,
            'booking_id' => 4,
            'sender_id' => 1,
            'receiver_id' => 2,
            'message' => 'I want to stay your home.',
            'type_id' => 4,
            'read' => 1,
            'archive' => 0,
            'star' => 0,
            'created_at' => '2020-12-03 00:23:05',
            'updated_at' => '2021-06-23 17:48:32'
            ],
        ]);
    }
}