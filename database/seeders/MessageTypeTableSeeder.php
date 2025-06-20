<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MessageTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('message_type')->truncate();

      DB::table('message_type')->insert([
        ['name' => 'query'],
        ['name' => 'guest_cancellation' ],
        ['name' => 'host_cancellation'],
        ['name' => 'booking_request'],
        ['name' => 'booking_accecpt'],
        ['name' => 'booking_decline'],
        ['name' => 'booking_expire'],
              
      ]);
    }
}