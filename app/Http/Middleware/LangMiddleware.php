<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // جلب اللغة من التطبيق والجلسة
        $locale = app('lang');
        $localeInSession = session('lang');

        if (empty($locale)) {
            $locale = 'ar';
        }
        if (empty($localeInSession)) {
            session(['lang' => 'ar']);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
