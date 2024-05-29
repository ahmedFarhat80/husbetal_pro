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
                    {{ __('Selected section') }} : {{ $Category }} | {{ __('The chosen doctor') }} :
                    {{ $doctor }} | {{ __('Selected date') }} : {{ $date }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
                <div class="tab-pane fade show active" id="step1">
                    <h4 class="pb-4 pt-1"> {{ __('Choose the Time') }}</h4>



                    <div class="vertical-tabs">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>

                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                &nbsp; {{ __('The duration of the session is') }} : {{ $add }}
                                {{ __('minute') }}
                            </div>
                        </div>


                        <div class="vertical-tabs">
                            <ul class="nav flex-column" id="clinicTabs" role="tablist">


                                @foreach ($Tims as $time)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="surgery-tab{{ $time->id }}" data-bs-toggle="tab"
                                            href="#surgery{{ $time->id }}" role="tab"
                                            aria-controls="surgery{{ $time->id }}" aria-selected="true"
                                            onclick="selectCategory({{ $time->id }})">
                                            {{ $time->time }} &nbsp; &nbsp;
                                            @if ($time->description != null)
                                                <span style="color: #4CAF50"> {{ $time->description }} </span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <br>
                        <h6 class="days-of-week">
                            {{ __('The chosen day') }}
                            :
                            <span id="selectedDay">{{ __("$day") }}</span>
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
            window.location.href = "/date"; // التحويل والانتقال
        }

        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
        toastr.success(
            "{{ __('The date has been selected and we move to the next step') }}"
        );
    </script>

    <script>
        var selectedCategoryId;

        function selectCategory(categoryId) {
            selectedCategoryId = categoryId;
        }

        function nextStep() {
            axios.post('/time', {
                    time: selectedCategoryId
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "/data_info"; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
