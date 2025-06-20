<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(AccountsTableSeeder::class);
      // $this->call(AdminsTableSeeder::class);
      $this->call(AmenitiesTableSeeder::class);
      $this->call(AmenityTypeTableSeeder::class);
      $this->call(BannersTableSeeder::class);
      $this->call(BedTypeTableSeeder::class);
      $this->call(CountryTableSeeder::class);
      $this->call(CurrencyTableSeeder::class);
      $this->call(EmailTemplateTableSeeder::class);
      $this->call(FavouritesTableSeeder::class);
      $this->call(LanguageTableSeeder::class);
      $this->call(MessagesTableSeeder::class);
      $this->call(MessageTypeTableSeeder::class);
      $this->call(PagesTableSeeder::class);
      $this->call(passwordResetTableSeeder::class);
      $this->call(PaymentMethodsTableSeeder::class);
      $this->call(PayoutsSettingsTableSeeder::class);
      $this->call(PayoutsTableSeeder::class);
      $this->call(PermissionsTableSeeder::class);
      // $this->call(PermissionRoleTableSeeder::class);
      $this->call(RoleAdminTableSeeder::class);
      $this->call(PropertiesAddressTableSeeder::class);
      $this->call(PropertiesDatesTableSeeder::class);
      $this->call(PropertiesDescriptionTableSeeder::class);
      $this->call(PropertiesImageTableSeeder::class);
      $this->call(PropertiesPriceTableSeeder::class);
      $this->call(PropertiesStepTableSeeder::class);
      $this->call(PropertiesTableSeeder::class);
      $this->call(PropertyFeesTableSeeder::class);
      $this->call(PropertyTypeTableSeeder::class);
      $this->call(ReviewsTableSeeder::class);
      $this->call(RolesTableSeeder::class);
      $this->call(RulesTableSeeder::class);
      $this->call(SeoMetasTableSeeder::class);
      $this->call(SettingsTableSeeder::class);
      $this->call(SpaceTypeTableSeeder::class);
      $this->call(StartingCitiesTableSeeder::class);
      $this->call(TestimonialTableSeeder::class);
      $this->call(TimezoneTableSeeder::class);
      $this->call(UsersDetailsTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      $this->call(BookingsTableSeeder::class);
      $this->call(UsersVerificationTableSeeder::class);
      $this->call(WalletsTableSeeder::class);
      $this->call(WithdrawalsTableSeeder::class);
      Artisan::call('module:seed Gateway');
    }
}
