<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->truncate();

        DB::table('bookings')->insert([
            [
            'id' => 1,
            'property_id' => 1,
            'code' => 'IhrEC1',
            'host_id' => 1,
            'user_id' => 2,
            'start_date' => '2020-12-03',
            'end_date' => '2020-12-03',
            'status' => 'Pending',
            'guest' => 1,
            'total_night' => 1,
            'per_night' => 5,
            'base_price' => 5,
            'cleaning_charge' => 0,
            'guest_charge' => 0,
            'service_charge' => 0,
            'security_money' => 0,
            'iva_tax' => 0,
            'accomodation_tax' => 0,
            'date_with_price' => NULL,
            'host_fee' => 0,
            'total' => 5,
            'booking_type' => 'request',
            'currency_code' => 'USD',
            'cancellation' => 'Flexible',
            'transaction_id' => '',
            'payment_method_id' => 0,
            'accepted_at' => NULL,
            'attachment' => NULL,
            'bank_id' => NULL,
            'note' => NULL,
            'created_at' => '2022-12-03 00:14:57',
            'updated_at' => '2022-12-03 00:14:57'
            ],
            [
            'id' => 2,
            'property_id' => 1,
            'code' => 'e3XDAn',
            'host_id' => 1,
            'user_id' => 2,
            'start_date' => '2021-06-24',
            'end_date' => '2021-06-25',
            'status' => 'Accepted',
            'guest' => 1,
            'total_night' => 1,
            'per_night' => 5,
            'base_price' => 5,
            'cleaning_charge' => 0,
            'guest_charge' => 0,
            'service_charge' => 0,
            'security_money' => 0,
            'iva_tax' => 0,
            'accomodation_tax' => 0,
            'date_with_price' => '[{\"price\":5,\"date\":\"2021-06-24\"}]',
            'host_fee' => 0,
            'total' => 5,
            'booking_type' => 'request',
            'currency_code' => 'USD',
            'cancellation' => 'Flexible',
            'transaction_id' => 'ch_1J5kYnDpvvQP5tMRYW4SVgEU',
            'payment_method_id' => 2,
            'accepted_at' => '2021-06-24 11:51:54',
            'attachment' => NULL,
            'bank_id' => NULL,
            'note' => NULL,
            'created_at' => '2023-06-24 11:51:13',
            'updated_at' => '2023-06-24 11:53:05'
            ],
            
            [
            'id' => 3,
            'property_id' => 3,
            'code' => 'gWEBQ8',
            'host_id' => 1,
            'user_id' => 2,
            'start_date' => '2020-12-04',
            'end_date' => '2020-12-04',
            'status' => 'Pending',
            'guest' => 1,
            'total_night' => 1,
            'per_night' => 7,
            'base_price' => 7,
            'cleaning_charge' => 0,
            'guest_charge' => 0,
            'service_charge' => 0,
            'security_money' => 0,
            'iva_tax' => 0,
            'accomodation_tax' => 0,
            'date_with_price' => NULL,
            'host_fee' => 0,
            'total' => 7,
            'booking_type' => 'request',
            'currency_code' => 'USD',
            'cancellation' => 'Flexible',
            'transaction_id' => '',
            'payment_method_id' => 0,
            'accepted_at' => NULL,
            'attachment' => NULL,
            'bank_id' => NULL,
            'note' => NULL,
            'created_at' => '2022-12-03 00:23:48',
            'updated_at' => '2022-12-03 00:23:48'
            ],
                
            [
            'id' => 4,
            'property_id' => 5,
            'code' => 'JFb4Wo',
            'host_id' => 2,
            'user_id' => 1,
            'start_date' => '2020-12-05',
            'end_date' => '2020-12-07',
            'status' => 'Pending',
            'guest' => 1,
            'total_night' => 1,
            'per_night' => 20,
            'base_price' => 21,
            'cleaning_charge' => 0,
            'guest_charge' => 0,
            'service_charge' => 1,
            'security_money' => 0,
            'iva_tax' => 0,
            'accomodation_tax' => 0,
            'date_with_price' => NULL,
            'host_fee' => 0,
            'total' => 21,
            'booking_type' => 'request',
            'currency_code' => 'USD',
            'cancellation' => 'Flexible',
            'transaction_id' => '',
            'payment_method_id' => 0,
            'accepted_at' => NULL,
            'attachment' => NULL,
            'bank_id' => NULL,
            'note' => NULL,
            'created_at' => '2022-12-03 00:23:05',
            'updated_at' => '2022-12-03 00:23:05'
            ]


        ]);
    }
}
