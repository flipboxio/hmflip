<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersVerificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_verification')->truncate();

        DB::table('users_verification')->insert([

            [
            'user_id'=>1,
            'email'=>'yes',
            'facebook'=>'yes',
            'google'=>'no',
            'linkedin'=>'no',
            'phone'=>'no',
            ],

            [
            'user_id'=>2,
            'email'=>'yes',
            'facebook'=>'yes',
            'google'=>'yes',
            'linkedin'=>'no',
            'phone'=>'no',
            ]

        ]);
    }
}
