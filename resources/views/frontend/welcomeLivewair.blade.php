<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المستشفى العسكري - نظام حجز المواعيد</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .nav-tabs {
            border-bottom: none;
            margin-bottom: 20px;
        }

        .nav-link {
            border: none;
            color: #495057;
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            /* إضافة */
        }

        .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
            border-radius: 5px;
        }

        .nav-link.active:before {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 3px;
            /* background-color: #007bff; */
            border-radius: 5px 5px 0 0;
        }

        .tab-pane {
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        .btn-primary,
        .btn-secondary {
            border-radius: 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff !important;
            border: 1px solid #007bff;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border: 1px solid #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: 1px solid #6c757d;
            padding: 10px 20px;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            border: 1px solid #545b62;
        }

        .select2-container .select2-selection--single {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }

        }
    </style>
    @php
        $language = session('lang');
    @endphp

    @if ($language == 'en')
        <style>
            *,
            .vertical-tabs .nav-link {
                direction: ltr !important;
                text-align: left !important;
            }

            .tab-content {
                text-align: left;
                padding: 20px;
            }

            body {
                direction: ltr !important;
            }
        </style>
    @endif

</head>

<body class="bg-light">

    <body class="bg-light">
        {{-- <div class="container mt-5"> --}}
        @livewire('Taps')
        @livewireScripts
        {{-- </div> --}}


        <!-- تضمين Bootstrap JS و Popper.js و jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    </body>

</html>
