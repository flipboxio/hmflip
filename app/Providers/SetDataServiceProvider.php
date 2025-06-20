<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{
    Currency,
    Language,
    Settings,
    StartingCities,
    Banners,
    Country,
    Page
};
use View, Config, Schema, App, Session, Validator;


class SetDataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        
        if (env('DB_DATABASE') && env('APP_INSTALL')) {
            if (Schema::hasTable('currency')) {
                $this->currency();
            }

            if (Schema::hasTable('language')) {
                $this->language();
            }

            if (Schema::hasTable('settings')) {
                $this->settings();
                $this->api_info_set();
            }
            if (Schema::hasTable('pages')) {
                $this->pages();
            }

            $this->creditcard_validation();

        }
    }

    public function creditcard_validation()
    {

        Validator::extend('expires', function ($attribute, $value, $parameters, $validator) {
            $input      = $validator->getData();
            $expiryDate = gmdate('Ym', gmmktime(0, 0, 0, (int) array_get($input, $parameters[0]), 1, (int) array_get($input, $parameters[1])));
            return ($expiryDate > gmdate('Ym')) ? true : false;
        });

        Validator::extend('validate_cc', function ($attribute, $value, $parameters) {
            $str = '';
            foreach (array_reverse(str_split($value)) as $i => $c) {
                $str .= $i % 2 ? $c * 2 : $c;
            }
            return array_sum(str_split($str)) % 10 === 0;
        });
    }

    public function register()
    {
        //
    }

    public function currency()
    {
        ini_set('max_execution_time', 300);

        $currencies = Currency::getAll()->where('status', '=', 'Active');
        View::share('currencies', $currencies);
        View::share('currency', $currencies->pluck('code', 'code'));

        if (!\Session::get('currency')) {
            try {
                if ($_SERVER["REMOTE_ADDR"]){
                    $remoteData = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=sadf' . $_SERVER["REMOTE_ADDR"]));
                    $default_currency = Currency::getAll()->where('status', '=', 'Active')->where('code', '=', $remoteData['geoplugin_currencyCode'])->first();
                    $default_country = $remoteData['geoplugin_countryCode'];
                }
            } catch (\Exception $e) {
                $default_currency = Currency::getAll()->firstWhere('default', '=', '1');
            }
        } else {
            $default_currency = Currency::getAll()->firstWhere('code', \Session::get('currency'));
        }

        if (!$default_currency) {
            $default_currency = Currency::getAll()->firstWhere('default', '=', '1');
        }

        if (!isset($default_country)) {
            $default_country = Country::getAll()->first()->short_name;
        }

        View::share('default_country', $default_country);
        View::share('default_currency', $default_currency);
        Session::put('currency', $default_currency->code);
        Session::put('symbol', $default_currency->symbol);
    }

    public function language()
    {
        $language = Language::where('status', '=', 'Active')->pluck('name', 'short_name');
        View::share('language', $language);

        $default_language = Language::where('status', '=', 'Active')->where('default', '=', '1')->first();

        if (empty($default_language)) {

            $default_language = (object)[];
            $default_language->name = 'English';
            $default_language->short_name = 'en';
        }
        
        View::share('default_language', $default_language);
        Session::put('language', $default_language->short_name);
        App::setLocale($default_language->short_name);

    }

    public function pages()
    {
        $footer_first  = Page::where('position', 'first')->where('status', 'Active')->get();
        $footer_second = Page::where('position', 'second')->where('status', 'Active')->get();
        View::share('footer_first', $footer_first);
        View::share('footer_second', $footer_second);
    }

    public function api_info_set()
    {
        $google   = Settings::where('type', 'google')->pluck('value', 'name')->toArray();
        $facebook = Settings::where('type', 'facebook')->pluck('value', 'name')->toArray();
        if (isset($google['client_id'])) {
            \Config::set(['services.google' => [
                    'client_id' => $google['client_id'],
                    'client_secret' => $google['client_secret'],
                    'redirect' => url('/googleAuthenticate'),
                    ]
                ]);
        }

        if (isset($facebook['client_id'])) {
             \Config::set(['services.facebook' => [
                        'client_id' => $facebook['client_id'],
                        'client_secret' => $facebook['client_secret'],
                        'redirect' => url('/facebookAuthenticate'),
                        ]
                        ]);
        }
    }


    public function settings()
    {
        $settings = Settings::getAll();
        if (!empty($settings)) {

            // General settings
            $general = $settings->where('type', 'general')->pluck('value', 'name')->toArray();
            $preference = $settings->where('type', 'preferences')->pluck('value', 'name')->toArray();
            
            Session::put('front_date_format_type', $preference['front_date_format_type']); 

            //App head code/Analytics code
            $headCode = !empty($general['head_code']) ? $general['head_code'] : env('APP_HEAD_CODE', '');
            View::share('head_code', $headCode);


            // Join us
            $join_us = Settings::where('type', 'join_us')->get();
            View::share('join_us', $join_us);

        }


    }
}
