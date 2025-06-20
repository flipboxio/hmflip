<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PropertiesPriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_price')->truncate();

        DB::table('property_price')->insert([

            [
            'property_id' => 1,
            'cleaning_fee' => 0,
            'guest_after' => 1,
            'guest_fee' => 0,
            'security_fee' => 0,
            'price' => 5,
            'weekend_price' => 0,
            'weekly_discount' => 0,
            'monthly_discount' => 0,
            'currency_code' => 'USD'
            ],

            [
            'property_id' => 2,
            'cleaning_fee' => 0,
            'guest_after' => 1,
            'guest_fee' => 0,
            'security_fee' => 0,
            'price' => 6,
            'weekend_price' => 0,
            'weekly_discount' => 0,
            'monthly_discount' => 0,
            'currency_code' => 'USD'
            ],

            [
            'property_id' => 3,
            'cleaning_fee' => 0,
            'guest_after' => 1,
            'guest_fee' => 0,
            'security_fee' => 0,
            'price' => 7,
            'weekend_price' => 0,
            'weekly_discount' => 0,
            'monthly_discount' => 0,
            'currency_code' => 'USD'
            ],

            [
            'property_id' => 4,
            'cleaning_fee' => 0,
            'guest_after' => 1,
            'guest_fee' => 0,
            'security_fee' => 0,
            'price' => 8,
            'weekend_price' => 0,
            'weekly_discount' => 0,
            'monthly_discount' => 0,
            'currency_code' => 'USD'
            ],

            [
            'property_id' => 5,
            'cleaning_fee' => 0,
            'guest_after' => 1,
            'guest_fee' => 0,
            'security_fee' => 0,
            'price' => 20,
            'weekend_price' => 0,
            'weekly_discount' => 0,
            'monthly_discount' => 0,
            'currency_code' => 'USD'
            ]


        ]);
    }
}
