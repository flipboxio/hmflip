<?php

namespace App\Providers;

use App\Models\{Bank, Settings};
use App\Observers\{BankObserver, SettingsObserver};
use Validator,Schema;
use Illuminate\Support\{ServiceProvider, Collection};
use Illuminate\Pagination\LengthAwarePaginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (env('DB_DATABASE') && env('APP_INSTALL')) {
            if (\Schema::hasTable('settings')) {
                $result = Settings::where('type', 'email')->pluck('value', 'name')->toArray();
                if (isset($result['driver'])) {
                    \Config::set([
                        'mail.driver'     => $result['driver'],
                        'mail.host'       => $result['host'],
                        'mail.port'       => $result['port'],
                        'mail.from'       => [
                                                'address' => $result['from_address'],
                                                'name'    => $result['from_name']
                                            ],
                        'mail.encryption' => $result['encryption'],
                        'mail.username'   => $result['username'],
                        'mail.password'   => $result['password']
                        ]);
                }
            }

            Settings::observe(SettingsObserver::class);
            Bank::observe(BankObserver::class);
        }
        // //For Home Currency Custom Validation Check
         $this->defaultHomeCurrency();
        // //For Default language Custom Validation Check
        // $this->defaultHomeLanguage();
        // //For Age check is the user 18 or not
         // $this->checkAge();

    }

    //For Home Currency Custom Validation Check
    public function defaultHomeCurrency()
    {
        Validator::extend('default_home_currency', function ($attribute, $value, $parameters, $validator) {
            $request          = app(\Illuminate\Http\Request::class);
            $homeCurrency     = Settings::getAll()->firstWhere('name', 'default_currency');
            if ($homeCurrency->value==Request()->segment(4) && $request->status=='Inactive') {
                return false;
            } else {
                return true;
            }
        });
    }
    //For Default Language Custom Validation Check
    public function defaultHomeLanguage()
    {
        Validator::extend('default_home_language', function ($attribute, $value, $parameters, $validator) {
            $request          = app(\Illuminate\Http\Request::class);
            $defaultLanguage  = Settings::where(['name'=>'default_language'])->first();
            if ($defaultLanguage->value==Request()->segment(4) && $request->status=='Inactive') {
                return false;
            } else {
                return true;
            }
        });
    }

    //For Date of birth check is 18 or not

    public function checkAge()
    {
        Validator::extend('check_age', function ($attribute, $value, $parameters, $validator) {
            $request   = app(\Illuminate\Http\Request::class);
            $dob       = $request->date_of_birth;
            $dobValue  = explode('-', $dob);
            if ($dobValue[0] && $dobValue[1] && $dobValue[2]) {
                $today     = new DateTime();
                $birthdate = new DateTime($dob);
                $interval  = $today->diff($birthdate);
                $age       = (int)$interval->format('%y');
                if ($age>=18) {
                    return true;
                } else {
                    return false;
                }
            }
        });
    }
}
