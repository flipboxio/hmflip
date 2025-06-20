<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class passwordResetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('password_resets')->truncate();
    	
        DB::table('password_resets')->insert([
        		['email' => 'william@gmail.com', 'token' => '9lFlkvcnpMk2dn2TOj3PaOj10ZGgg6Q223mzT60MT5R5OeLsCektr6XPqMQGJu2qIoPqFy02GqwjLaaMp3SGtZ7sMv0hGrN2XNqk','created_at' => NULL],
        		['email' => 'john@techvill.net', 'token' => '8tMJR90rLjEtEJxn7DFyS7uxLZYdnERGDn9TP6k3gol1UN2HmjBqdd5KRYaWqWSWUFFbiMkLsuESDbvZthVbVxfYsb0Tmu1nb6V5','created_at' => NULL],
        		['email' => 'william@techvill.net', 'token' => 'jEMELKpbIg9CKs0dkU6rcpjL4QkRc5MeUK8c1aJdGJgB3y34rw8nb9EomklsH6xKH1oIwR301tc1AqsEWQYJr4kCmlDTvzD46pS2','created_at' => NULL],
        		['email' => 'william@gmail.com', 'token' => '9lFlkvcnpMk2dn2TOj3PaOj10ZGgg6Q223mzT60MT5R5OeLsCektr6XPqMQGJu2qIoPqFy02GqwjLaaMp3SGtZ7sMv0hGrN2XNqk','created_at' => NULL],
        		['email' => 'john@techvill.net', 'token' => '8tMJR90rLjEtEJxn7DFyS7uxLZYdnERGDn9TP6k3gol1UN2HmjBqdd5KRYaWqWSWUFFbiMkLsuESDbvZthVbVxfYsb0Tmu1nb6V5','created_at' => NULL],
        		['email' => 'william@techvill.net', 'token' => 'jEMELKpbIg9CKs0dkU6rcpjL4QkRc5MeUK8c1aJdGJgB3y34rw8nb9EomklsH6xKH1oIwR301tc1AqsEWQYJr4kCmlDTvzD46pS2','created_at' => NULL],
        	]);
    }
}
