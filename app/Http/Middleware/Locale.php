<?php

namespace App\Http\Middleware;

use Closure, Session, App;

class Locale
{
    public function handle($request, Closure $next)
    {
        if (Session::get('language')) {
            App::setLocale(Session::get('language'));
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
