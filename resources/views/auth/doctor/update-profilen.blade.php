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

        /* تخصيص مظهر التلميحات */
        .tooltip-inner {
            background-color: #343a40;
            /* لون الخلفية */
            color: #fff;
            /* لون النص */
            border-radius: 8px;
            /* شكل الحواف */
            padding: 8px 12px;
            /* هامش داخلي */
            font-size: 14px;
            /* حجم الخط */
            max-width: 250px;
            /* عرض أقصى */
        }

        /* تخصيص مظهر السهم */
        .tooltip.bs-tooltip-top .tooltip-arrow,
        .tooltip.bs-tooltip-bottom .tooltip-arrow {
            border-color: #343a40 transparent;
            /* لون السهم */
        }
    </style>
</head>

<body dir="@if (App()->getLocale() == 'ar') rtl @else ltr @endif">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-md-6">
                <div class="clinic-logo">
                    <img src="{{ asset('logo.png') }}" alt="logo">
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
                        {{ __('It is just one step away to create your account in the system') }}
                    </h4>
                    <form method="POST" action="{{ route('update.sendVerification') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control" name="email"
                                placeholder="{{ __('Your E-mail') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('Enter your email - used to send messages and alerts from system administrators') }}">
                        </div>
                        <div class="form-group position-relative">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="{{ __('New Password') }}" required autocomplete="new-password">
                            <span toggle="#password"
                                class="eye toggle-password position-absolute top-50 translate-middle-y @if (App::getLocale() == 'ar') start-0 translate-middle @else end-0 translate-middle @endif"></span>
                        </div>

                        <div class="form-group position-relative">
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required
                                autocomplete="new-password">
                            <span toggle="#password_confirmation"
                                class="eye toggle-password position-absolute top-50 translate-middle-y @if (App::getLocale() == 'ar') start-0 translate-middle @else end-0 translate-middle @endif"></span>
                        </div>


                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <br>
                            @if (App::getLocale() == 'ar')
                                <a class="btn btn-outline-primary" href="{{ url('/lang', 'en') }}">
                                    Cahnge lang in English
                                </a>
                            @else
                                <a class="btn btn-outline-primary" href="{{ url('/lang', 'ar') }}">
                                    تغير اللغه الى العربية
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary"> {{ __('Save Data') }} </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // قائمة بأسماء الصور
        const images = ["back-1.jpg", "back-2.jpg", "back-3.jpg", "back-4.jpg", "back-5.jpg", "back-6.jpg"];

        // تحديد عنصر الخلفية
        const body = document.querySelector("body");

        // اختيار صورة افتراضية
        const randomIndex = Math.floor(Math.random() * images.length);
        const randomImage = images[randomIndex];
        body.style.backgroundImage = `url('{{ asset('${randomImage}') }}')`;

        // تغيير الصورة كل 5 ثوانٍ
        setInterval(() => {
            const randomIndex = Math.floor(Math.random() * images.length);
            const randomImage = images[randomIndex];
            body.style.backgroundImage = `url('{{ asset('${randomImage}') }}')`;
        }, 5000);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                $(this).toggleClass("active");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });

        $(document).ready(function() {
            $(".toggle-password2").click(function() {
                $(this).toggleClass("active");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });
    </script>
    <script>
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>

</body>

</html>
