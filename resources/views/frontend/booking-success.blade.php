@extends('frontend.welcome')

@section('CSS')
    <style>
        #datepicker {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        #datepicker:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        /* في نطاق الأسلوب أو ملف CSS المستخدم في مشروعك */
        .days-of-week {
            margin: 0;
            padding: 0;
        }

        .days-of-week span {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 20px;
            /* تحديد التباعد بين أيام الأسبوع */
            font-weight: bold;
            color: #3498db;
            /* لون النص */
        }

        .days-of-week span::after {
            /* content: "-"; */
            margin-left: 5px;
            /* تحديد التباعد بين النصوص والشرطة */
            color: #666;
            /* لون الشرطة */
        }

        #gif {
            width: 150px;
        }
    </style>
@endsection

@section('container')
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>


        <div class="card w-100">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h2 class="text-center flex-grow-1">{{ __('Military Hospital appointments') }}</h2>
                <div class="language-switcher">
                    @if (session('lang') == 'ar')
                        <a href="{{ url('lang/en') }}" class="btn btn-sm btn-outline-light">{{ __('English') }}</a>
                    @else
                        <a href="{{ url('lang/ar') }}" class="btn btn-sm btn-outline-light">{{ __('العربية') }}</a>
                    @endif
                </div>
            </div>

            <div class="card-body text-center">
                <img id="gif" src="{{ asset('assets/ok.gif') }}" width="150px">
                <h4 class="text-center">{{ __('Booking Successful!') }}</h4>
                <p class="text-center">{{ __('Your appointment has been successfully booked.') }}</p>
                <p class="text-center">{{ __('Thank you for using the Military Hospital appointment system.') }}</p>
                <p class="text-center">{{ __('Your reservation ID is') }} : <span style="color: #4CAF50">
                        {{ $id }} <span></p>
            </div>


            <div class="row">

                <div class="col-12">
                    <button class="btn btn-custom w-100 d-flex justify-content-center" onclick="brevesStep()">
                        {{ __('Go To The Home Page') }}
                    </button>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('JS')
    <script>
        function brevesStep() {
            window.location.href = "/data_info"; // التحويل والانتقال
        }
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
    </script>
@endsection
