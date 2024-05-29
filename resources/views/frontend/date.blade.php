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
                    {{ __('Selected section') }} : {{ $Category }}-| {{ __('The chosen doctor') }} :
                    {{ $doctor }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="tab-pane fade show active" id="step1">
                    <h4 class="pb-4 pt-1"> {{ __('Choose the date') }}</h4>

                    <p class="days-of-week"> {{ __('Doctor working days') }} :
                        @foreach ($Dayworks as $Daywork)
                            <span>
                                @if ($Daywork->day7 == 1)
                                    {{ __('Saturday') }}
                                @endif
                                @if ($Daywork->day1 == 1)
                                    &nbsp;- {{ __('Sunday') }}
                                @endif
                                @if ($Daywork->day2 == 1)
                                    &nbsp;- {{ __('Monday') }}
                                @endif
                                @if ($Daywork->day3 == 1)
                                    &nbsp;- {{ __('Tuesday') }}
                                @endif
                                @if ($Daywork->day4 == 1)
                                    &nbsp;- {{ __('Wednesday') }}
                                @endif
                                @if ($Daywork->day5 == 1)
                                    &nbsp;- {{ __('Thursday') }}
                                @endif
                                @if ($Daywork->day6 == 1)
                                    &nbsp;- {{ __('Friday') }}
                                @endif
                            </span>
                        @endforeach
                    </p>

                    <div class="vertical-tabs">
                        <div class="vertical-tabs">
                            <input type="text" class="form-control" id="datepicker" readonly
                                placeholder="{{ __('Choose a date') }}">
                        </div>

                        <br>
                        <h6 class="days-of-week">
                            {{ __('The chosen day') }}
                            :
                            <span id="selectedDay"></span>
                        </h6>
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
            window.location.href = "/doctor"; // التحويل والانتقال
        }
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
        toastr.success(
            "{{ __('The doctor has been selected and we move to the next step') }}"
        );
    </script>
    <script>
        function nextStep() {
            axios.post('dateSelct_ok/', {
                    datepicker: document.getElementById('datepicker').value
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "time"; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>

    @php
        $language = session('lang');
    @endphp

    <!-- في قسم الجسم -->
    <script>
        $(function() {
            var disabledDates = @json($disabledDates);
            var doctorWorkingDays = @json($Dayworks);

            // الحصول على تاريخ اليوم
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // يناير يبدأ من 0
            var yyyy = today.getFullYear();
            var currentDate = yyyy + '-' + mm + '-' + dd;

            $("#datepicker").datepicker({
                beforeShowDay: function(date) {
                    var dayOfWeek = date.getDay();
                    var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                    var isDateDisabled = disabledDates.includes(formattedDate);
                    var isDayAvailable = doctorWorkingDays.some(function(day) {
                        return day['day' + (dayOfWeek + 1)] == 1;
                    });
                    return [!isDateDisabled && isDayAvailable];
                },
                minDate: new Date(currentDate), // تعيين تاريخ اليوم كحد أدنى
                onSelect: function(dateText, inst) {
                    // عند اختيار التاريخ، حدث قيمة العنصر
                    var selectedDate = new Date(dateText);
                    var selectedDayIndex = selectedDate.getDay();

                    @if ($language == 'en')
                        var selectedDayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',
                            'Friday', 'Saturday'
                        ];
                    @else
                        var selectedDayNames = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس',
                            'الجمعة', 'السبت'
                        ];
                    @endif
                    var selectedDayName = selectedDayNames[selectedDayIndex];

                    $("#selectedDay").text(selectedDayName);
                }
            });
        });
    </script>
@endsection
