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


            <div class="card-body">
                <div class="summary-section mt-4">
                    <h4 class="text-center mb-4">
                        {{ __('Booking summary') }}
                    </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="summary-item">
                                <strong>{{ __('First Name') }}:</strong> {{ session('user_data.firstName') }}
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Middle Name') }}:</strong> {{ session('user_data.middleName') }}
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Family Name') }}:</strong> {{ session('user_data.lastName') }}
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Phone Number') }}:</strong> {{ session('user_data.phoneNumber') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-item">
                                <strong>{{ __('Date') }}:</strong> <span
                                    id="summaryDate">{{ session('user_data.date') }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Day') }}:</strong> <span id="summaryDay">
                                    @php
                                        $timestamp = strtotime(session('user_data.date'));
                                        $dayOfWeek = strtoupper(date('l', $timestamp));
                                        $day = constant("App\Enums\DayOfWeek::$dayOfWeek");
                                    @endphp
                                    {{ __("$dayOfWeek") }}
                                </span>
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Section') }}:</strong> <span
                                    id="summaryDepartment">{{ $Category }}</span>
                            </div>
                            @if (session('user_data.day') != null)
                                <div class="summary-item">
                                    <strong>{{ __('Card expiration') }}:</strong> <span
                                        id="summaryDepartment">{{ session('user_data.day') }}/{{ session('user_data.month') }}/{{ session('user_data.year') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="summary-item">
                                <strong>{{ __('Name Doctor') }}:</strong> <span
                                    id="summaryDoctor">{{ $doctor }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Time') }}:</strong> <span id="summaryTime">{{ $time }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('ID number') }}:</strong>
                                {{ session('user_data.idNumber') }}
                            </div>
                            <div class="summary-item">
                                <strong>{{ __('Card Type') }}:</strong> {{ __(session('user_data.idType')) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <button class="btn btn-custom-2 w-100 d-flex justify-content-center" onclick="brevesStep()">
                        {{ __('previous') }}
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-custom w-100 d-flex justify-content-center" onclick="nextStep()">
                        {{ __('Reservation Confirmation') }}
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
        toastr.success(
            "{{ __('We are almost done. Confirm your reservation details') }}"
        );
    </script>


    <script>
        function nextStep() {
            axios.post('/booking-summary', {

                })
                .then(function(response) {
                    toastr.success(response.data.message);
                    window.location.href = "/booking-success/" + response.data.rand; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
