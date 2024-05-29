@extends('frontend.welcome')

@section('CSS')
    <style>
        .vertical-tabs {
            margin-bottom: 20px;
        }

        .complaint-form label {
            font-weight: bold;
            color: #333;
        }

        .complaint-form select,
        .complaint-form textarea,
        .complaint-form input[type="tel"],
        .complaint-form input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .complaint-form select:focus,
        .complaint-form textarea:focus,
        .complaint-form input[type="tel"]:focus,
        .complaint-form input[type="text"]:focus {
            border-color: #e75c;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .complaint-form button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #e75c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .complaint-form button[type="submit"]:hover {
            background-color: #e75c3c;
        }

        .complaint-form label {
            display: block;
            margin-bottom: 10px !important;
            color: #333;
        }

        .complaint-form input[type="tel"],
        .complaint-form input[type="text"],
        .complaint-form select,
        .complaint-form textarea {
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
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
                <form class="complaint-form" id="create-form">
                    @csrf
                    <div class="vertical-tabs">
                        <label for="complaint_type">{{ __('Select Complaint Type') }}</label>
                        <select class="form-control" id="complaint_type">
                            <option value="" selected hidden>{{ __('Select Complaint Type') }}</option>
                            <option value="system">{{ __("A problem with the system's operation") }}</option>
                            <option value="doctor">{{ __('A complaint against a specific doctor or department') }}</option>
                        </select>
                    </div>



                    <div id="doctor-complaint-fields" class="hidden">
                        <div class="vertical-tabs">
                            <label for="department">{{ __('Select Department') }}</label>
                            <select class="form-control" id="department">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="vertical-tabs">
                            <label for="doctor">{{ __('Select Doctor') }}</label>
                            <select class="form-control" id="doctor">
                                <option value="0">{{ __('All doctors in the department') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="vertical-tabs">
                        <label for="name">{{ __('Your Name') }}</label>
                        <input type="text" class="form-control"
                            placeholder="{{ __('Please enter') }} {{ __('Your Name') }}" id="name">
                    </div>


                    <div class="form-group mb-3">
                        <label for="phoneNumber">{{ __('Your Phone Number') }}:</label>
                        <input type="text" pattern="[0-9]{8}" max="8" min="8" maxlength="8"
                            class="form-control" id="phoneNumber"
                            placeholder="{{ __('Please enter') }} {{ __('Phone Number') }}"
                            value="{{ session('user_data.phoneNumber') }}">
                    </div>


                    <div class="vertical-tabs">
                        <label for="idNumber">{{ __('Your ID Number') }}</label>
                        <input type="text" class="form-control" id="idNumber"
                            placeholder="{{ __('Please enter') }} {{ __('Your ID Number') }}">
                    </div>
                    <div class="vertical-tabs">
                        <label for="doctor_complaint_description">{{ __('Complaint Description') }}</label>
                        <textarea class="form-control" id="doctor_complaint_description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-custom-2 w-100 d-flex justify-content-center" onclick="previousStep()">
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
        function previousStep() {
            window.location.href = "/"; // التحويل والانتقال
        }
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
    </script>

    <script>
        var currentLang = "{{ app()->getLocale() }}"; // الحصول على اللغة الحالية للنظام مباشرة من Laravel

        $(document).ready(function() {
            $('#complaint_type').on('change', function() {
                var complaintType = $(this).val();
                if (complaintType === 'system') {
                    $('#system-complaint-fields').removeClass('hidden');
                    $('#doctor-complaint-fields').addClass('hidden');
                } else if (complaintType === 'doctor') {
                    $('#doctor-complaint-fields').removeClass('hidden');
                    $('#system-complaint-fields').addClass('hidden');
                } else {
                    $('#system-complaint-fields').addClass('hidden');
                    $('#doctor-complaint-fields').addClass('hidden');
                }
            });

            $('#department').on('change', function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    $.ajax({
                        url: '{{ route('fetch.doctors') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            department_id: departmentId
                        },
                        success: function(data) {
                            $('#doctor').empty();
                            $('#doctor').append(
                                '<option value="0">{{ __('All doctors in the department') }}</option>'
                            );
                            $.each(data.doctors, function(key, doctor) {
                                $('#doctor').append('<option value="' + doctor.id +
                                    '">' + doctor.name[currentLang] + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>


    <script>
        function nextStep() {
            var complaintType = document.getElementById('complaint_type').value;
            var department = document.getElementById('department').value;
            var doctor = document.getElementById('doctor').value;

            if (complaintType === 'doctor' && (!department || !doctor)) {
                toastr.error("{{ __('Please select a department and a doctor') }}");
                return;
            }

            axios.post('/Complaints', {
                    complaint_type: document.getElementById('complaint_type').value,
                    name: document.getElementById('name').value,
                    phoneNumber: document.getElementById('phoneNumber').value,
                    idNumber: document.getElementById('idNumber').value,
                    doctor_complaint_description: document.getElementById('doctor_complaint_description').value,
                    doctor: document.getElementById('doctor').value,
                    department: document.getElementById('department').value,

                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    setTimeout(function() {
                        window.location.replace("/");
                    }, 2000);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
