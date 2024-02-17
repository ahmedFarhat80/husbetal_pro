<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>المستشفى العسكري - نظام حجز المواعيد</title>

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <style>
        /* .bg-light {
            background-color: rgba(255, 214, 148, 0.863) !important;
        } */

        .container {
            background-color: rgba(245, 233, 233, 0.863);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 290px;
            max-height: 290px;
        }

        .progress-container {
            margin-bottom: 30px;
        }

        .nav-pills .nav-link {
            border-radius: 0.25rem;
            padding: 12px 20px;
            margin-right: 5px;
            color: #fff;
            background-color: #007bff;
            font-weight: bold;
        }

        .nav-pills .nav-link.active {
            background-color: #0056b3;
        }

        .tab-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }

        h4 {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-weight: bold;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .disabled-link {
            pointer-events: none;
            /* تعطيل التفاعل مع الرابط */
            color: #6c757d !important;
            /* تغيير لون الرابط إلى لون معتم */
            cursor: not-allowed;
            /* تغيير شكل المؤشر ليشير إلى عدم الإمكانية */
        }

        .toast-top-center {
            margin-top: 30px;
            /* Adjust the margin as needed */
        }
    </style>
    @yield('CSS')

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
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>

<body class="bg-light">
    @yield('container')

    <br><br><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    @yield('JS')
    <script>
        function searchDepartments() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var clinicTabs = document.querySelectorAll(".nav-link");
            clinicTabs.forEach(function(tab) {
                var tabName = tab.textContent.toLowerCase();
                if (tabName.includes(input)) {
                    tab.style.display = "block";
                } else {
                    tab.style.display = "none";
                }
            });
        }
    </script>
    <script>
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
        // toastr.info('Are you the 6 fingered man?')
    </script>



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



</body>

</html>
