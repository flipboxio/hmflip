<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SeoMetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seo_metas')->truncate();

        DB::table('seo_metas')->insert([
                ['url' => '/', 'title' => 'Home | Vrent Home', 'description' => 'Vacation Rentals, Cabins, Beach Houses, Unique Homes & Experiences'],
                ['url' => 'login', 'title' => 'Log In', 'description' => 'Log In'],
                ['url' => 'register', 'title' => 'Register', 'description' => 'Register'],
                ['url' => 'newest', 'title' => 'Newest Photos', 'description' => 'Newest Photos'],
                ['url' => 'forgot_password', 'title' => 'Forgot Password', 'description' => 'Forgot Password'],
                ['url' => 'dashboard', 'title' => 'Feeds', 'description' => 'Feeds'],
                ['url' => 'uploads', 'title' => 'Uploads', 'description' => 'Uploads'],
                ['url' => 'notification', 'title' => 'Notification', 'description' => 'Notification'],
                ['url' => 'profile', 'title' => 'Profile', 'description' => 'Profile'],
                ['url' => 'profile/{id}', 'title' => 'Profile', 'description' => 'Profile'],
                ['url' => 'manage-photos', 'title' => 'Manage Photos', 'description' => 'Manage Photos'],
                ['url' => 'earning', 'title' => 'Earning', 'description' => 'Earning'],
                ['url' => 'purchase', 'title' => 'Purchase', 'description' => 'Purchase'],
                ['url' => 'settings', 'title' => 'Settings', 'description' => 'Settings'],
                ['url' => 'settings/account', 'title' => 'Settings', 'description' => 'Settings'],
                ['url' => 'settings/payment', 'title' => 'Settings', 'description' => 'Settings'],
                ['url' => 'photo/single/{id}', 'title' => 'Photo Single', 'description' => 'Photo Single'],
                ['url' => 'payments/success', 'title' => 'Payment Success', 'description' => 'Payment Success'],
                ['url' => 'payments/cancel', 'title' => 'Payment Cancel', 'description' => 'Payment Cancel'],
                ['url' => 'profile-uploads/{type}', 'title' => 'Profile Uploads', 'description' => 'Profile Uploads'],
            	['url' => 'photo-details/{id}', 'title' => 'Photo Details', 'description' => 'Photo Details'],
                ['url' => 'withdraws', 'title' => 'Withdraws', 'description' => 'Withdraws'],
                ['url' => 'photos/download/{id}', 'title' => 'Photos Download', 'description' => 'Photos Download'],
            	['url' => 'users/reset_password/{secret?}', 'title' => 'Reset Password', 'description' => 'Reset Password'],
                ['url' => 'search/{word}', 'title' => 'Search Result', 'description' => 'Search Result'],
                ['url' => 'search/user/{word}', 'title' => 'Search User Result', 'description' => 'Search User Result'],
                ['url' => 'signup', 'title' => 'Signup', 'description' => 'Signup'],
                ['url' => 'property/create', 'title' => 'Create New Property', 'description' => 'Create New Property'],

                ['url' => 'listing/{id}/{step}', 'title' => 'Property Listing', 'description' => 'Property Listing'],

                ['url' => 'properties', 'title' => 'Properties', 'description' => 'Properties'],
                ['url' => 'my_bookings', 'title' => 'My Bookings', 'description' => 'My Bookings'],

                ['url' => 'trips/active', 'title' => 'Your Trips', 'description' => 'Your Trips'],

                ['url' => 'users/profile', 'title' => 'Edit Profile', 'description' => 'Edit Profile'],

                ['url' => 'users/account_preferences', 'title' => 'Account Preferences', 'description' => 'Account Preferences'],

                ['url' => 'users/transaction_history', 'title' => 'Transaction History', 'description' => 'Transaction History'],

                 ['url' => 'users/security', 'title' => 'Security', 'description' => 'Security'],

                ['url' => 'search', 'title' => 'Search', 'description' => 'Search'],

                ['url' => 'inbox', 'title' => 'Inbox', 'description' => 'Inbox'],

                ['url' => 'users/profile/media', 'title' => 'Profile Photo', 'description' => 'Profile Photo'],

                ['url' => 'booking/requested', 'title' => 'Payment Completed', 'description' => 'Payment Completed'],

                ['url' => 'user/favourite', 'title' => 'Favourite List', 'description' => ''],

            ]);
    }
}
