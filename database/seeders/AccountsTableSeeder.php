<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->truncate();
    	
        DB::table('accounts')->insert([
        		['user_id' => '1', 'currency_code' => 'USD', 'account' => 'test@techvill.net', 'payment_method_id' => '1', 'selected' => 'No', 'created_at' => NULL, 'updated_at' => NULL],
        		['user_id' => '2', 'currency_code' => 'USD', 'account' => 'customer@techvill.net', 'payment_method_id' => '1', 'selected' => 'No', 'created_at' => NULL, 'updated_at' => NULL],
        		['user_id' => '3', 'currency_code' => 'USD', 'account' => 'william@techvill.net', 'payment_method_id' => '1', 'selected' => 'No', 'created_at' => NULL, 'updated_at' => NULL],
        		['user_id' => '4', 'currency_code' => 'USD', 'account' => 'john@techvill.net', 'payment_method_id' => '1', 'selected' => 'No', 'created_at' => NULL, 'updated_at' => NULL],
        		
        	]);
    }
}
