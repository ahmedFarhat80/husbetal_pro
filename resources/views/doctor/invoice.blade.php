<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (app()->getLocale() == 'ar')
            فاتورة المستشفى
        @else
            Hospital bill
        @endif
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .patient-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .patient-info p {
            margin: 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .patient-info p strong {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            box-sizing: border-box;
            border-radius: 10px;
            margin: 30px auto;
            width: 90%;
            max-width: 920px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
        }

        .title {
            margin-bottom: 20px;
            text-align: center;
            color: #FFA500;
            border-bottom: 2px solid #FFA500;
            padding-bottom: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .patient-info {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .patient-info p {
            margin: 5px 0;
            color: #333;
            text-align: right;
            font-size: 16px;
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table.table-bordered {
            border: 1px solid #ddd;
        }

        .table.table-bordered th,
        .table.table-bordered td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .table.table-bordered th {
            background-color: #f2f2f2;
            color: #333;
        }

        .table.table-bordered tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .signature {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
    @if (app()->getLocale() != 'ar')
        <style>
            body .patient-info p {
                direction: ltr !important;
                text-align: left !important;
            }
        </style>
    @endif
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('logo.png') }}" alt="شعار المستشفى" style="width: 150px;max-width: 150px;">
        </div>
        <div class="title">
            {{ __('Medical Services Authority - Military Hospital Appointment System') }}
        </div>
        <div class="patient-info">
            <p><strong>{{ __('Order ID') }}:</strong> {{ $data->id }}</p>
            <p><strong>{{ __('Name') }}:</strong> {{ $data->first_name }} {{ $data->middle_name }}
                {{ $data->last_name }}</p>
            <p><strong>{{ __('ID number') }}:</strong> {{ $data->id_number }}</p>
            <p><strong>{{ __('Card Type') }}:</strong> {{ __("$data->id_type") }}</p>
            @if ($data->id_type == 'بطاقة العائلة')
                <p><strong>{{ __('Card expiry date') }}:</strong>
                    {{ $data->day }}/{{ $data->month }}/{{ $data->year }}
                </p>
            @endif
            <p><strong>{{ __('The date of application') }}:</strong> {{ $data->created_at->format('m/d/Y') }}</p>
        </div>
        <table class="table table-bordered details">
            <thead>
                <tr>
                    <th>{{ __('Section') }}</th>
                    <th>{{ __('Doctor') }}</th>
                    <th>{{ __('Date of reservation within the clinic') }}</th>
                    <th>{{ __('Day of booking') }}</th>

                    <th>
                        {{ __('Booking time') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->Categories->name }}</td>
                    <td>
                        @auth('web')
                            @php
                                echo $doctorCount = App\Models\Doctor::where('id', $data->doctor_id)->first()->name;
                            @endphp
                        @endauth
                        @guest('web')
                            {{ Auth::user()->name }}
                        @endguest
                    </td>
                    <td>{{ $data->date }}</td>
                    <td>
                        @if ($data->Time->day == 'day7')
                            {{ __('Saturday') }}
                        @endif
                        @if ($data->Time->day == 'day1')
                            {{ __('Sunday') }}
                        @endif
                        @if ($data->Time->day == 'day2')
                            {{ __('Monday') }}
                        @endif
                        @if ($data->Time->day == 'day3')
                            {{ __('Tuesday') }}
                        @endif
                        @if ($data->Time->day == 'day4')
                            {{ __('Wednesday') }}
                        @endif
                        @if ($data->Time->day == 'day5')
                            {{ __('Thursday') }}
                        @endif
                        @if ($data->Time->day == 'day6')
                            {{ __('Friday') }}
                        @endif
                    </td>
                    <td>{{ $data->Time->time }}</td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p>{{ __('This invoice was issued upon request') }} {{ Auth::user()->name }}.</p>
        </div>
        <div class="signature">
            <p>{{ __('Programming and development by Captain Mishal al-Hindi') }}</p>
            <p>{{ __('Contact: 51197963') }}</p>
        </div>
    </div>
</body>

</html>
