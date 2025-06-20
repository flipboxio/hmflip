<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PayoutsSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payout_settings')->truncate();
    	
        DB::table('payout_settings')->insert([
            
        [
            'id' => 1,
            'user_id' => 2,
            'type' => 1,
            'email' => 'customer@techvill.net',
            'account_name' => 'Customer User',
            'is_active' => 1,
            'selected' => 'No',
            'created_at' => NULL,
            'updated_at' => NULL
            ],
                        
            [
            'id' => 2,
            'user_id' => 1,
            'type' => 1,
            'email' => 'test@techvill.net',
            'account_name' => 'Test User',
            'is_active' => 1,
            'selected' => 'No',
            'created_at' => NULL,
            'updated_at' => NULL
            ]
        ]);
    }
}
