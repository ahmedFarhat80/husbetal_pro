<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>المستشفى العسكري - نظام حجز المواعيد</title>

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
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
            color: #6c757d !important;
            cursor: not-allowed;
        }

        .toast-top-center {
            margin-top: 30px;
        }

        .footer {
            background-color: rgba(245, 233, 233, 0.863);
            border-top: 1px solid #e9ecef;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
        }

        .footer .text-muted {
            color: #6c757d;
            font-size: 14px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .complaint-suggestion-text {
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            color: #333;
        }

        .complaint-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s, text-decoration 0.3s;
        }

        .complaint-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .contact-info {
            font-size: 16px;
            color: #333;
        }

        .contact-btn {
            background-color: #e75c3c !important;
            color: #fff !important;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .contact-btn:hover {
            background-color: #d14e33 !important;
            color: #fff !important;
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

            .logo-container,
            .complaint-suggestion-text {
                text-align: center !important;
            }
        </style>
    @endif
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="bg-light">
    @yield('container')
    <br>
    <br>
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted"> {{ __('Programming and development by Captain Mishal al-Hindi') }} </span>
            <br>
            <span class="text-muted">{{ __('All rights reserved to the Kuwaiti Army') }}© {{ date('Y') }}</span>
            <br>
        </div>
        <br>
        <p class="complaint-suggestion-text">

            {{ __('If you encounter any problems or have any suggestions you would like to share, you can now submit complaints and suggestions by going to') }}
            <a href="{{ route('complaints') }}" class="complaint-link">
                {{ __('Complaints Department') }}
            </a>.
        </p>
        <p class="contact-info text-center m-4 pb-4">
            {{ __('Contact Captain / Mishaal Al-Hindi') }}
            <a href="https://wa.me/+96551197963" target="_blank" class="btn btn-info contact-btn">51197963</a>
        </p>

    </footer>

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
            "positionClass": "toast-top-center",
            "timeOut": 3000,
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>
