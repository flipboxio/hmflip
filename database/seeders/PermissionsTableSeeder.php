<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        DB::table('permissions')->insert([
              ['name' => 'manage_admin', 'display_name' => 'Manage Admin', 'description' => 'Manage Admin Users', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'customers', 'display_name' => 'View Customers', 'description' => 'View Customer', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'add_customer', 'display_name' => 'Add Customer', 'description' => 'Add Customer', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'edit_customer', 'display_name' => 'Edit Customer', 'description' => 'Edit Customer', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'delete_customer', 'display_name' => 'Delete Customer', 'description' => 'Delete Customer', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'properties', 'display_name' => 'View Properties', 'description' => 'View Properties', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'add_properties', 'display_name' => 'Add Properties', 'description' => 'Add Properties', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'edit_properties', 'display_name' => 'Edit Properties', 'description' => 'Edit Properties', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'delete_property', 'display_name' => 'Delete Property', 'description' => 'Delete Property', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_bookings', 'display_name' => 'Manage Bookings', 'description' => 'Manage Bookings', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_email_template', 'display_name' => 'Manage Email Template', 'description' => 'Manage Email Template', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'view_payouts', 'display_name' => 'View Payouts', 'description' => 'View Payouts', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_amenities', 'display_name' => 'Manage Amenities', 'description' => 'Manage Amenities', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_pages', 'display_name' => 'Manage Pages', 'description' => 'Manage Pages', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_reviews', 'display_name' => 'Manage Reviews', 'description' => 'Manage Reviews', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'View Reports', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'general_setting', 'display_name' => 'Settings', 'description' => 'Settings', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'preference', 'display_name' => 'Preference', 'description' => 'Preference', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_banners', 'display_name' => 'Manage Banners', 'description' => 'Manage Banners', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'starting_cities_settings', 'display_name' => 'Starting Cities Settings', 'description' => 'Starting Cities Settings', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_property_type', 'display_name' => 'Manage Property Type', 'description' => 'Manage Property Type', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'space_type_setting', 'display_name' => 'Space Type Setting', 'description' => 'Space Type Setting', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_bed_type', 'display_name' => 'Manage Bed Type', 'description' => 'Manage Bed Type', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_currency', 'display_name' => 'Manage Currency', 'description' => 'Manage Currency', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_country', 'display_name' => 'Manage Country', 'description' => 'Manage Country', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_amenities_type', 'display_name' => 'Manage Amenities Type', 'description' => 'Manage Amenities Type', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'email_settings', 'display_name' => 'Email Settings', 'description' => 'Email Settings', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_fees', 'display_name' => 'Manage Fees', 'description' => 'Manage Fees', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_language', 'display_name' => 'Manage Language', 'description' => 'Manage Language', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_metas', 'display_name' => 'Manage Metas', 'description' => 'Manage Metas', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'api_informations', 'display_name' => 'Api Credentials', 'description' => 'Api Credentials', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'payment_settings', 'display_name' => 'Payment Settings', 'description' => 'Payment Settings', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'social_links', 'display_name' => 'Social Links', 'description' => 'Social Links', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_roles', 'display_name' => 'Manage Roles', 'description' => 'Manage Roles', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'database_backup', 'display_name' => 'Database Backup', 'description' => 'Database Backup', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_sms', 'display_name' => 'Manage SMS', 'description' => 'Manage SMS', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_messages', 'display_name' => 'Manage Messages', 'description' => 'Manage Messages', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'edit_messages', 'display_name' => 'Edit Messages', 'description' => 'Edit Messages', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'manage_testimonial', 'display_name' => 'Manage Testimonial', 'description' => 'Manage Testimonial', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'add_testimonial', 'display_name' => 'Add Testimonial', 'description' => 'Add Testimonial', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'edit_testimonial', 'display_name' => 'Edit Testimonial', 'description' => 'Edit Testimonial', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'delete_testimonial', 'display_name' => 'Delete Testimonial', 'description' => 'Delete Testimonial', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'social_logins', 'display_name' => 'Social Logins', 'description' => 'Manage Social Logins', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'addons', 'display_name' => 'Addons', 'description' => 'Manage Addons', 'created_at' => NULL,'updated_at' => NULL],
              ['name' => 'google_recaptcha', 'display_name' => 'Google Recaptcha', 'description' => 'Manage Google Recaptcha', 'created_at' => NULL,'updated_at' => NULL],

        ]);
    }
}
