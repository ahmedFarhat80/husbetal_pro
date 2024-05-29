<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class SetUserLanguage
{
    public function handle($request, Closure $next)
    {
        // تحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
        if (Auth::check()) {
            // احصل على تفضيلات اللغة من قاعدة البيانات
            $userLanguage = Auth::user()->language;

            // تحديد اللغة إذا كانت محددة
            if ($userLanguage) {
                App::setLocale($userLanguage);
            }
        }

        return $next($request);
    }
}
