<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Pipeline;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest;

use App\Actions\Fortify\AttemptToAuthenticate;
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\sendVerificationRequest;
use App\Http\Services\Mobile2000Service;
use App\Models\BannedIpAddress;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Middleware\FrameGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LoginResponse;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class DoctorAuthController extends Controller
{
    protected $mobile2000Service;



    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard, Mobile2000Service $mobile2000Service)
    {
        $this->guard = $guard;
        $this->mobile2000Service = $mobile2000Service;
    }

    /**
     * Show the login view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LoginViewResponse
     */
    public function create(Request $request): LoginViewResponse
    {
        return app(LoginViewResponse::class);
    }

    public function loginForm()
    {
        return view('auth.doctor.login', ['guard' => 'doctor']);
    }
    /**
     * Attempt to authenticate a new session.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        // ابحث عن مستخدم يطابق الرقم الوطني
        $user = Doctor::where('national_id', $request->national_id)->first();
        // التحقق من وجود المستخدم وتطابق كلمة المرور
        if ($user && $user->email === null && Hash::check($request->password, $user->password)) {
            // Auth::login($user);
            $request->session()->put('national_id', $request->national_id);

            return redirect()->route('update.profile');
        } elseif (!$user) {
            // إذا وجد المستخدم او لم يوجد ولكن لم يتوافق كلمة المرور، قم بتوجيه المستخدم إلى الصفحة السابقة مع رسالة الخطأ
            return back()->withErrors(['credentials' => __('These credentials do not match our records.')]);
        } else {
            $user_email = Doctor::where('national_id', $request->national_id)->first()->email;
            $request->merge(['email' => $user_email]);
            return $this->loginPipeline($request)->then(function ($request) {
                return app(LoginResponse::class);
            });
        }
    }

    /**
     * Get the authentication pipeline instance.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }

    public function updateLanguage(Request $request)
    {
        // قم بتحديث لغة المستخدم هنا، اعتمادًا على هيكل جدول المستخدمين في تطبيقك
        Auth::user()->update([
            'language' => $request->language,
        ]);

        return back()->with('success', 'Language updated successfully');
    }

    public function update_profile()
    {
        return view('auth.doctor.update-profilen');
    }


    public function sendVerification(sendVerificationRequest $request)
    {
        $verificationCode = random_int(111111, 999999);
        $national_id = $request->session()->get('national_id');
        $doctor = Doctor::where('national_id',  $national_id)->first();
        $doctor->code =  $verificationCode;
        $doctor->save();
        $phoneNumber = $doctor->phone_number;


        $request->session()->put('doctor_data', [
            'email' => $request->email,
            'password' => $request->password,
            'national_id' => $national_id,
            'phoneNumber' => $doctor->phone_number
        ]);
        // $response = $this->mobile2000Service->sendVerificationCode($verificationCode, $phoneNumber);
        // // $response = $this->mobile2000Service->sendVerificationCode($verificationCode, $phoneNumber);
        return response()->view("auth.doctor.verify-code");
    }

    public function RE_sendVerification(Request $request)
    {
        $doctor_data = $request->session()->get('doctor_data');
        $national_id = $doctor_data['national_id'];

        if (!empty($doctor_data['email']) && !empty($doctor_data['password']) && !empty($doctor_data['national_id'])) {
            $doctor = Doctor::where('national_id',  $national_id)->first();

            // التحقق ما إذا كان يمكن إعادة إرسال الرمز بناءً على الوقت المحدد
            $lastSentTime = $doctor->last_verification_sent_at;
            $currentTime = now();
            $secondsSinceLastSend = $currentTime->diffInSeconds($lastSentTime);
            $minimumInterval = 30; // الفاصل الزمني الأدنى بين إرسالين للرمز بالثواني

            if ($secondsSinceLastSend >= $minimumInterval) {
                // بعد التحقق من أن المدة المنقضية منذ آخر إرسال تزيد عن الفاصل الزمني المطلوب
                $verificationCode = random_int(111111, 999999);
                $doctor->code = $verificationCode;
                $doctor->last_verification_sent_at = $currentTime; // تحديث الوقت للإرسال الأخير
                $doctor->save();
                $phoneNumber = $doctor->phone_number;
                // $response = $this->mobile2000Service->sendVerificationCode($verificationCode, $phoneNumber);

                // إعادة توجيه أو رد بناءً على الحالة الناجحة للإرسال
            } else {
                // في حالة عدم الامتثال لمتطلبات الفاصل الزمني
                $remainingTime = $minimumInterval - $secondsSinceLastSend;
                return back()->withErrors(['resend_error' => __('You can resend the verification code after :seconds seconds', ['seconds' => $remainingTime])]);
            }
        } else {
            // إذا كانت البيانات غير كاملة، قم بإعادة التوجيه مع رسالة الخطأ
            return back()->withErrors(['credentials' => __('These credentials do not match our records.')]);
        }
    }

    public function ConfirmsendVerification(CodeRequest $request)
    {

        $national_id = $request->session()->get('national_id');
        $doctor_data = $request->session()->get('doctor_data');

        $doctor = Doctor::where('national_id',  $national_id)->first();
        if ($doctor->code == $request->code) {
            $doctor->email = $doctor_data['email'];
            $password = $doctor_data['password'];

            $doctor->password = Hash::make($password);
            $issave = $doctor->save();
        } else {

            return response()->json(['message' =>   __('The verification code is invalid')],   Response::HTTP_BAD_REQUEST);
        }
    }



    public function blocked(Request $request)
    {
        $blockedIp_exists = BannedIpAddress::where('ip_address', $request->ip())->exists();
        $blockedIp = BannedIpAddress::where('ip_address', $request->ip())->first();

        if ($blockedIp_exists) {
            $banExpiry = Carbon::parse($blockedIp->ban_expiry);
            $remainingTime = now()->diffInSeconds($banExpiry);
        } else {
            $remainingTime = 0; // If the IP is not blocked, set remaining time to 0
        }
        return response()->view('auth.blocked_page', compact('blockedIp_exists', 'blockedIp', 'remainingTime'));
    }
}
