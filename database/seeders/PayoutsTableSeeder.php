<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PayoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payouts')->truncate();
    	
        DB::table('payouts')->insert([
            [
                                                  
                'id' => 1,
                'booking_id' => 1,
                'user_id' => 1,
                'property_id' => 1,
                'user_type' => 'Host',
                'amount' => 5,
                'penalty_amount' => 0,
                'status' => 'Future',
                'currency_code' => 'USD',
                'created_at' => '2021-06-24 11:51:54',
                'updated_at' => '2021-06-24 11:51:54'
                ],
                                        
                [
                'id' => 2,
                'booking_id' => 1,
                'user_id' => 1,
                'property_id' => 1,
                'user_type' => 'Host',
                'amount' => 5,
                'penalty_amount' => 0,
                'status' => 'Future',
                'currency_code' => 'USD',
                'created_at' => '2021-06-24 11:53:06',
                'updated_at' => '2021-06-24 11:53:06'
                ]
        	]);
    }
}
