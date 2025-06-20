<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->truncate();

        DB::table('wallets')->insert([

            [
            'user_id' => 1,
            'currency_id' => 1,
            'balance' => '3.00',
            'is_active' => 1,
            'created_at' => NULL,
            'updated_at' => NULL
            ],

            [
            'user_id' => 2,
            'currency_id' => 1,
            'balance' => '0.00',
            'is_active' => 1,
            'created_at' => NULL,
            'updated_at' => NULL
            ]
        ]);
    }
}
