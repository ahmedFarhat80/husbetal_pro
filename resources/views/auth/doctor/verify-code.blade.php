<!DOCTYPE html>
@if (App::getLocale() == 'ar')
    <html dir="rtl">
@else
    <html dir="ltr">
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الطبيب - المستشفى</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: "cairo";
            color: #333;
            transition: background 1s ease-in-out;
        }

        html[dir="rtl"] body {
            direction: rtl !important;
        }

        html[dir="ltr"] body {
            direction: ltr !important;
        }


        .login-container {
            max-width: 450px;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 89%);
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
        }

        .login-container h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-container .form-group {
            margin-bottom: 20px;
        }

        .login-container .form-control {
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
        }

        .login-container .btn-primary {
            border-radius: 10px;
            width: 100%;
            background-color: #00adef;
            border-color: #00adef;
            font-size: 18px;
            padding: 12px;
        }

        .login-container .btn-primary:hover {
            background-color: #0054ef;
            border-color: #0054ef;
        }

        .login-container .checkbox-inline {
            font-size: 16px;
        }

        .clinic-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .clinic-logo img {
            margin-top: 40px;
            max-width: 200px;
            height: auto;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert ul {
            margin-top: 0.5rem;
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        .alert ul li {
            list-style-type: disc;
        }

        .checkbox-inline {
            direction: ltr !important;
        }

        .form-check-input {
            margin-left: 10px;
            /* توسيع المسافة بين الزر والنص */
        }

        .eye {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .eye::before {
            content: '\f06e';
            /* رمز العين */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .eye.active::before {
            content: '\f070';
            /* رمز العين المغلقة */
        }

        /* تحديد موقع العين بناءً على اتجاه النص */
        html[dir="rtl"] .eye {
            left: 6%;
        }

        html[dir="ltr"] .eye {
            right: 3%;
        }
    </style>
</head>

<body dir="@if (App()->getLocale() == 'ar') rtl @else ltr @endif">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-md-6">
                <div class="clinic-logo">
                    <img src="{{ asset('logo.png') }}" alt="شعار العيادة">
                </div>
                <div class="login-container">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ __('Whoops! Something went wrong.') }}</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h4>
                        {{-- {{ __('Doctor login') }} --}}
                    </h4>
                    <form method="POST" action="{{ route('ConfirmsendVerification') }}">
                        @csrf
                        <div class="form-group">
                            <input type="number" class="form-control" name="code" id="code"
                                placeholder="{{ __('Enter the code') }}" autofocus inputmode="numeric" lang="en">
                        </div>
                        <div id="resendContainer" style="text-align: center; margin-top: 20px;">
                            <p id="resendMessage" style="">
                                {{ __('If you did not receive the code, you can resend it after 30 seconds') }}.
                            </p>
                            <button id="resendButton" type="button" class="btn btn-primary" style="display: none;"
                                onclick="sendVerificationCode()">
                                {{ __('Resend Verification Code') }}
                            </button>
                            <p id="countdown" style="display: none;"></p>
                        </div>
                        <button type="button" class="mt-3 btn btn-primary" onclick="ConfirmsendVerification()">
                            {{ __('Confirm the code') }} </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Toastr رسائل الخطاء  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    <script>
        var resendButton = document.getElementById('resendButton');
        var resendMessage = document.getElementById('resendMessage');
        var countdownDisplay = document.getElementById('countdown');

        var remainingTime = 30; // عدد الثواني المتبقية لإعادة الإرسال
        var resendInterval;

        function updateResendText() {
            remainingTime--;
            resendMessage.innerText =
                '{{ __('If you did not receive the code, you can resend it after :seconds seconds.', ['seconds' => '']) }}' +
                remainingTime;
            if (remainingTime <= 0) {
                clearInterval(resendInterval);
                resendButton.style.display = 'block'; // عرض زر إعادة الإرسال عند الانتهاء من العداد
                countdownDisplay.style.display = 'none'; // إخفاء العداد
            }
        }

        function sendVerificationCode() {
            axios.post('/doctor/update/profile/resendVerification/', {
                    code: document.getElementById('code').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(
                        "{{ __('The new verification code has been sent to your phone number successfully') }}");

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
                .then(function() {
                    // always executed
                }); // تنفيذ الكود الذي يقوم بإعادة إرسال رمز التحقق
            // على سبيل المثال، بعد الانتهاء من الإرسال:
            clearInterval(resendInterval);
            remainingTime = 30; // إعادة تعيين الوقت المتبقي
            resendButton.style.display = 'none'; // إخفاء زر إعادة الإرسال
            countdownDisplay.style.display = 'block'; // عرض العداد بعد إعادة الإرسال
            updateResendText(); // تحديث العداد بشكل أولي
            resendInterval = setInterval(updateResendText, 1000); // تحديث العداد كل ثانية
        }

        // بداية المراقبة لإظهار زر إعادة الإرسال بعد مرور الوقت المناسب
        setTimeout(function() {
            resendButton.style.display = 'block'; // عرض زر إعادة الإرسال بعد انتهاء الوقت المحدد
        }, 30000); // 30 ثانية
    </script>





    <script>
        function ConfirmsendVerification() {
            axios.post('/doctor/update/profile/ConfirmsendVerification', {
                    code: document.getElementById('code').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);

                    setTimeout(function() {
                        window.location.href = "/doctor/dashboard";
                    }, 1000);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
                .then(function() {
                    // always executed
                });
        }
    </script>


</body>

</html>
