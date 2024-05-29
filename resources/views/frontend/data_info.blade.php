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
                <div class="alert alert-info alert-dismissible fade show d-flex justify-content-between align-items-center"
                    role="alert">
                    <div>
                        {{ __('Selected section') }} : {{ $Category }} | {{ __('The chosen doctor') }} :
                        {{ $doctor }} | {{ __('Selected date') }} : {{ $date }} |
                        {{ __('The chosen day') }} :
                        <span id="selectedDay">
                            @if ($Tims->day == 'day7')
                                {{ __('Saturday') }}
                            @endif
                            @if ($Tims->day == 'day1')
                                {{ __('Sunday') }}
                            @endif
                            @if ($Tims->day == 'day2')
                                {{ __('Monday') }}
                            @endif
                            @if ($Tims->day == 'day3')
                                {{ __('Tuesday') }}
                            @endif
                            @if ($Tims->day == 'day4')
                                {{ __('Wednesday') }}
                            @endif
                            @if ($Tims->day == 'day5')
                                {{ __('Thursday') }}
                            @endif
                            @if ($Tims->day == 'day6')
                                {{ __('Friday') }}
                            @endif
                        </span>
                        | {{ __('Session hour') }} : {{ $Tims->time }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


                <div class="tab-pane fade show active" id="step1">
                    <form action="">
                        <div class="patient-info-section mt-4">
                            <h4 class="text-center mb-4">{{ __('Patient data') }}</h4>
                            <div class="form-group mb-3">
                                <label for="firstName">{{ __('First Name') }}:</label>
                                <input type="text" class="form-control" id="firstName"
                                    placeholder="{{ __('Please enter first name') }}"
                                    value="{{ session('user_data.firstName') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="middleName">{{ __('The Second Name') }}:</label>
                                <input type="text" class="form-control" id="middleName"
                                    placeholder="{{ __('Please enter') }} {{ __('The Second Name') }}"
                                    value="{{ session('user_data.middleName') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="lastName">{{ __('Family Name') }}:</label>
                                <input type="text" class="form-control" id="lastName"
                                    placeholder="{{ __('Please enter') }} {{ __('Family Name') }}"
                                    value="{{ session('user_data.lastName') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="phoneNumber">{{ __('Phone Number') }}:</label>
                                <input type="text" pattern="[0-9]{8}" max="8" min="8" maxlength="8"
                                    class="form-control" id="phoneNumber"
                                    placeholder="{{ __('Please enter') }} {{ __('Phone Number') }}"
                                    value="{{ session('user_data.phoneNumber') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="idNumber"> {{ __('File number/military ID number') }}:</label>
                                <input type="text" class="form-control" id="idNumber"
                                    placeholder="{{ __('Please enter') }} {{ __('File number/military ID number') }}"
                                    value="{{ session('user_data.phoneNumber') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="idType">{{ __('Card Type') }}:</label>
                                <select class="form-control" id="idType">
                                    <option value="هوية عسكرية"
                                        {{ session('user_data.idType') == 'هوية عسكرية' ? 'selected' : '' }}>
                                        {{ __('Military ID') }}
                                    </option>
                                    <option value="بطاقة العائلة"
                                        {{ session('user_data.idType') == 'بطاقة العائلة' ? 'selected' : '' }}>
                                        {{ __('Family Card') }}
                                    </option>
                                    <option value="موظف مدني"
                                        {{ session('user_data.idType') == 'موظف مدني' ? 'selected' : '' }}>
                                        {{ __('Civil servant') }}
                                    </option>
                                </select>

                            </div>

                            <div class="form-group mb-3" id="dream"
                                @if (session('user_data.idType') == 'بطاقة العائلة') @else style="display: none;" @endif>
                                <label> {{ __('Card expiry date') }} </label>
                                <div class="expiry-date">
                                    <label for="day" class="p-2">{{ __('day') }}: </label>
                                    <input class="form-control" type="number" id="day" name="day" min="1"
                                        max="31" value="{{ session('user_data.day') }}">
                                    <label for="month" class="p-2">{{ __('Month') }}: </label>
                                    <input class="form-control" type="number" id="month" name="month" min="1"
                                        max="12" value="{{ session('user_data.month') }}">
                                    <label for="year" class="p-2">{{ __('year') }}: </label>
                                    <input class="form-control" type="number" id="year" name="year" min="2023"
                                        max="2099" value="{{ session('user_data.year') }}">
                                </div>
                            </div>
                        </div>
                    </form>
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
                        {{ __('Next') }}
                    </button>
                </div>

            </div>

        </div>
    </div>
@endsection



@section('JS')
    <script>
        function brevesStep() {
            window.location.href = "/time"; // التحويل والانتقال
        }
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
        toastr.success(
            "{{ __('The time has been selected and we move to the next step') }}"
        );
    </script>

    <script>
        var idType = document.getElementById("idType");
        var dreamDiv = document.getElementById("dream");
        var dayInput = document.getElementById("day");
        var monthInput = document.getElementById("month");
        var yearInput = document.getElementById("year");

        idType.addEventListener("input", function() {
            if (idType.value === "بطاقة العائلة") {
                dreamDiv.style.display = "block";
            } else {
                dreamDiv.style.display = "none";
            }
        });

        function validateExpiryDate() {
            var day = parseInt(dayInput.value);
            var month = parseInt(monthInput.value);
            var year = parseInt(yearInput.value);

            // التحقق من وجود قيم صحيحة لليوم والشهر والسنة
            if (isNaN(day) || isNaN(month) || isNaN(year)) {
                toastr.error("{{ __('Please enter the card expiry date correctly') }}");
                return false;
            }

            // التحقق من اليوم
            if (day < 1 || day > 31) {
                toastr.error("{{ __('Please enter a valid day value (from 1 to 31)') }}");
                return false;
            }

            // التحقق من الشهر
            if (month < 1 || month > 12) {
                toastr.error("{{ __('Please enter a valid month value (from 1 to 12)') }}");
                return false;
            }

            // التحقق من السنة
            if (year < 2023 || year > 2099) {
                toastr.error("{{ __('Please enter a valid year value (from 2023 to 2099)') }}");
                return false;
            }
            return true;
        }

        function nextStep() {
            // تحقق من اختيار "بطاقة العائلة"
            if (idType.value === "بطاقة العائلة") {
                // تحقق من صحة تاريخ انتهاء البطاقة
                if (!validateExpiryDate()) {
                    return; // إذا كان التحقق غير صالح، لا تواصل
                }
            }

            // استمرار العمليات الأخرى إذا كان التحقق صالحًا
            axios.post('/data_info', {
                    firstName: document.getElementById('firstName').value,
                    middleName: document.getElementById('middleName').value,
                    lastName: document.getElementById('lastName').value,
                    phoneNumber: document.getElementById('phoneNumber').value,
                    idNumber: document.getElementById('idNumber').value,
                    idType: document.getElementById('idType').value,
                    day: document.getElementById('day').value,
                    month: document.getElementById('month').value,
                    year: document.getElementById('year').value
                })
                .then(function(response) {
                    console.log(response);
                    // toastr.success(response.data.message);
                    window.location.href = "/booking-summary"; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
