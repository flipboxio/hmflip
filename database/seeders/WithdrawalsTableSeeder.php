<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class WithdrawalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('withdrawals')->truncate();

        DB::table('withdrawals')->insert([

            [
            'user_id' => 1,
            'payout_id' => 1,
            'currency_id' => 1,
            'payment_method_id' => 1,
            'uuid' => '5fc88cc41ec14',
            'subtotal' => '0.00',
            'amount' => '2.00',
            'email' => 'test@techvill.net',
            'status' => 'Success',
            'created_at' => '2020-12-01 00:00:00',
            'updated_at' => '2020-12-01 00:00:00'
            ],

            [
            'user_id' => 1,
            'payout_id' => 2,
            'currency_id' => 1,
            'payment_method_id' => 1,
            'uuid' => '5fc898f1464a9',
            'subtotal' => '2.00',
            'amount' => NULL,
            'email' => 'test@techvill.net',
            'status' => 'Pending',
            'created_at' => '2020-12-02 00:00:00',
            'updated_at' => '2020-12-02 00:00:00'
            ]

        ]);
    }
}
