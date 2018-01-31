<?php

namespace KW\Transactions\Http\Middleware;

use Closure;
use App;
use Auth;
use View;
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //localize for language
        App::setLocale($request->cookie('kwts_lang',\Config::get('app.locale')));
        if (Auth::check()) {
            App::setLocale(Auth::user()->language->code);
            setlocale(LC_TIME,Auth::user()->locale->code.'.UTF-8');
            setlocale(LC_MONETARY,Auth::user()->currency->locale.'.UTF-8');
        }
        $response = $next($request);
        $response->withCookie(cookie()->forever('kwts_lang', App::getLocale()));
        return $response;
    }
}
