<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $national_id = $request->session()->get('national_id');

        // استرجاع الطبيب المتعلق برقم الهوية الوطنية
        $doctor = Doctor::where('national_id',  $national_id)->first();
        if ($doctor && $doctor->email == null) {
            return $next($request);
        }
        // إعادة توجيه الطبيب إذا كان لديه بريداً الكترونياً
        return redirect()->route('doctor.login')->withErrors(['credentials' => __('You are not authorized to access this page.')]);
    }
}
