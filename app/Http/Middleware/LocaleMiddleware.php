<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('Accept-Language', 'en'); // Default to 'en'
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
        }
        return $next($request);
    }


}
