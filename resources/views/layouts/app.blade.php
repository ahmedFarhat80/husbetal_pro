<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-be2dc9b6.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @php
        $language = app()->getlocale('lang');
    @endphp

    @if ($language == 'ar')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
        <style>
            *,
            {
            direction: rtl !important;
            font-family: 'cairo' !important;
            }

            .font-sans,
            .h1,
            .h2,
            .h3,
            .h4,
            .h5,
            .h6,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'cairo' !important;

            }

            .btn-primary {
                background-color: #0d6efd !important;
                /* زيادة التباعد داخل الزر */
            }

            .space-x-8>:not([hidden])~:not([hidden]) {
                --tw-space-x-reverse: 0;
                margin-left: calc(0rem * var(--tw-space-x-reverse));
                margin-right: calc(2rem * calc(1 - var(--tw-space-x-reverse)));
            }

            body {
                direction: rtl !important;
            }

            .form-check .form-check-input {
                float: right;
                margin-right: -2.25rem;
            }
        </style>
    @endif
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    @yield('CSS')
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">

    <style>
        /* أنماط للأزرار الرئيسية */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        /* أنماط للأزرار الثانوية */
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        /* أنماط للأزرار الناجحة */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        /* أنماط للأزرار الخطرة */
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        /* أنماط للأزرار التحذيرية */
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        /* أنماط للأزرار الإعلامية */
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }

        /* أنماط للأزرار الفاتحة */
        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            color: #000;
        }

        /* أنماط للأزرار الداكنة */
        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
            color: #fff;
        }

        /* أنماط للأزرار الرابطة */
        .btn-link {
            background-color: transparent;
            border-color: transparent;
            color: #007bff;
        }

        /* أنماط للأزرار الرئيسية عند مرور المؤشر */
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: #fff;
        }

        /* أنماط للأزرار الثانوية عند مرور المؤشر */
        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #545b62;
            color: #fff;
        }

        /* أنماط للأزرار الناجحة عند مرور المؤشر */
        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
            color: #fff;
        }

        /* أنماط للأزرار الخطرة عند مرور المؤشر */
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
            color: #fff;
        }

        /* أنماط للأزرار التحذيرية عند مرور المؤشر */
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #000;
        }

        /* أنماط للأزرار الإعلامية عند مرور المؤشر */
        .btn-info:hover {
            background-color: #138496;
            border-color: #138496;
            color: #fff;
        }

        /* أنماط للأزرار الفاتحة عند مرور المؤشر */
        .btn-light:hover {
            background-color: #dae0e5;
            border-color: #dae0e5;
            color: #000;
        }

        /* أنماط للأزرار الداكنة عند مرور المؤشر */
        .btn-dark:hover {
            background-color: #23272b;
            border-color: #23272b;
            color: #fff;
        }

        /* أنماط للأزرار الرابطة عند مرور المؤشر */
        .btn-link:hover {
            background-color: transparent;
            border-color: transparent;
            color: #0056b3;
        }

        /* تخصيص الأنماط العامة للفورم */
        .form-control {
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        /* تخصيص أنماط الحقل عندما يكون في حالة التركيز */
        .form-control:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        /* تخصيص أنماط الكلمات التوجيهية (form-text) */
        .form-text {
            color: #6c757d;
        }

        /* تخصيص أنماط التسميات (form-label) */
        .form-label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #212529;
        }

        .form-check {
            display: block;
            min-height: 1.5rem;
            padding-right: 2.25rem;
            margin-bottom: 0.125rem;
        }

        .form-check:not(.form-switch) .form-check-input[type=checkbox] {
            background-size: 60% 60%;
        }

        .form-check-input[type=checkbox] {
            border-radius: 0.45em;
        }


        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .form-check-input {
            --bs-form-check-bg: transparent;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: -0.125rem;
            vertical-align: top;
            background-color: var(--bs-form-check-bg);
            background-image: var(--bs-form-check-bg-image);
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid var(--bs-gray-300);
            appearance: none;
            print-color-adjust: exact;
        }

        .form-select {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .form-select::-ms-expand {
            display: none;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-KJ3w/cB/yKo0p4Bnlq1gs6/DLA8F6gkdtdr7z1UAX/XOl2zp1TK4XqNK87S0CpQdLpOBiu8qCQT2nhjaenHJcQ=="
        crossorigin="anonymous" />
    @stack('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    {{-- <script src="{{ asset('build/assets/app-ddee773b.js') }}"></script> --}}
    <!-- Add Bootstrap-datepicker JavaScript -->

    <script src="{{ asset('js/datatable.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}

    <script src="{{ asset('assets/fontawesome/all.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('JS')

    @livewireScripts
</body>

</html>
