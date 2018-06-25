<?php

namespace App\Http\Middleware;

use Closure;

class DetectLanguageMiddleware
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
        $language = $request->cookie('shop_laravel_language');
        if (empty($language))
        {
            $language='zh-TW';
        }
        app()->setLocale($language);
        return $next($request);
    }
}
