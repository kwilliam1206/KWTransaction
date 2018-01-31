<?php

namespace KW\Transactions\Http\Middleware;

use Closure;
use Auth;
use KW\Transactions\Models\Office;

class SetCurrentOffice
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
        $response = $next($request);

        $cookieName = 'kw_office';
        if (Auth::check()) {
            $office = Auth::user()->offices()->first();
            $response->withCookie(cookie()->forever($cookieName, $office->id));
        }

        return $response;
    }
}
