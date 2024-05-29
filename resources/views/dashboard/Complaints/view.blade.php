<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Complaint Details') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            direction: ltr;
        }

        button {
            font-family: 'Cairo' !important;

        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header .logo {
            max-width: 140px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .sub-header h2 {
            margin: 0;
            color: #4CAF50;
            font-size: 20px;
        }

        .complaint-details {
            border-top: 2px solid #4CAF50;
            padding-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detail {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        span,
        p {
            display: block;
            color: #555;
            margin-top: 5px;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }

        .footer p {
            margin: 5px 0;
        }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }

            .actions {
                display: none;
            }

            .container {
                box-shadow: none;
                border: none;
            }
        }

        [lang="ar"] {
            direction: rtl;
            text-align: right;
        }

        [lang="ar"] .header h1,
        [lang="ar"] .sub-header h2,
        [lang="ar"] label {
            font-weight: bold;
        }

        [lang="ar"] .detail span,
        [lang="ar"] .detail p {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container" lang="ar">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            <h1>{{ __('Medical Services Authority - Military Hospital Complaints System') }}</h1>
        </div>
        <div class="sub-header">
            <h2>{{ __('Complaint Details') }}</h2>
        </div>
        <div class="complaint-details">
            <div class="detail">
                <label>{{ __('Complaint Type') }}:</label>
                <span id="complaint_type">
                    {{ __("$data->complaint_type") }}
                </span>
            </div>
            @if ($data->complaint_type == 'doctor')
                <div class="detail">
                    <label>{{ __('Department') }}:</label>
                    <span id="department">{{ $data->Category->name }}</span>
                </div>
                <div class="detail">
                    <label>{{ __('Doctor') }}:</label>
                    <span id="doctor">
                        @if ($data->doctor_id == 0)
                            {{ __('All doctors in the department') }}
                        @else
                            @php
                                $doctor = App\Models\Doctor::findOrFail($data->doctor_id)->name;
                                echo $doctor;
                            @endphp
                        @endif
                    </span>
                </div>
            @endif

            <div class="detail">
                <label>{{ __('name') }}:</label>
                <span id="name">{{ $data->user_name }}</span>
            </div>
            <div class="detail">
                <label>{{ __('Phone Number') }}:</label>
                <span id="phone_number"> {{ $data->phone_number }} </span>
            </div>
            <div class="detail">
                <label>{{ __('File number/military ID number') }}:</label>
                <span id="id_number"> {{ $data->id_number }} </span>
            </div>
            <div class="detail" style="grid-column: span 2;">
                <label>{{ __('Complaint Description') }}:</label>
                <p id="description">{{ $data->description }} </p>
            </div>
        </div>
        <div class="actions">
            <button onclick="window.print()">{{ __('Print the complaint') }}</button>
        </div>
        <div class="footer">
            <p>{{ __('Programming and development by Captain Mishal al-Hindi') }}</p>
            <p>{{ __('Contact: 51197963') }}</p>
        </div>
    </div>
</body>

</html>
