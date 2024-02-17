<!DOCTYPE html>
@if (App::getLocale() == 'ar')
    <html dir="rtl" lang="{{ app()->getLocale() }}">
@else
    <html dir="ltr" lang="{{ app()->getLocale() }}">
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Blocked Page') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300&family=Cairo:wght@200..1000&display=swap"
        rel="stylesheet">
    <style>
        /* Center content vertically */
        body {
            background-color: #f8f9fa;
            font-family: 'cairo' !important;
        }

        html[dir="rtl"] body {
            direction: rtl !important;
        }

        html[dir="ltr"] body {
            direction: ltr !important;
        }


        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            /* Added to align items vertically */
        }

        /* Additional styles */
        .countdown {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #dc3545;
        }

        .btn {
            margin-right: 10px;
        }

        /* Logo and Support styles */
        .logo {
            max-width: 150px;
            /* Adjust as needed */
            margin-bottom: 20px;
        }

        .support {
            font-size: 18px;
            margin-top: 20px;
            /* Move support text to top */
            color: #6c757d;
            /* Set text color */
        }

        /* Footer styles */
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            /* Footer background color */
            color: #ffffff;
            /* Footer text color */
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        @if ($blockedIp_exists == true)
            <div class="text-center">
                <h1 class="mb-4">{{ __("Sorry, You're Blocked!") }}</h1>
                <p class="mb-4">
                    {{ __('You have been blocked due to suspicious behavior. You can try again after 4 hours or contact technical support') }}
                </p>
                <div class="countdown mb-4" id="countdown">{{ __('Time remaining until the ban is lifted :') }} --:--:--
                </div>
                <button class="btn btn-lg btn-primary" onclick="refreshPage()">{{ __('Refresh Page') }}</button>
            </div>
        @else
            <div class="text-center">
                <h1 class="mb-4">{{ __('Welcome!') }}</h1>
                <p class="mb-4">
                    {{ __('You have not violated any rules. Enjoy using our system!') }}
                </p>
                <div class="icon mb-4">
                    <img src="{{ asset('OK.gif') }}" alt="OK">
                </div>
                <a href="{{ url('/') }}" class="btn btn-lg btn-primary">{{ __('Home page') }}</a>
            </div>
        @endif


    </div>
    <!-- Support Section -->
    <footer>
        <p class="support">{{ __('For support, contact us at: ') }} +96555176769</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <!-- Custom JS -->
    <script>
        function refreshPage() {
            location.reload();
        }

        // Assuming `remainingTime` is a variable containing the number of seconds until unblock
        var remainingTime = {{ $remainingTime }};

        function updateCountdown() {
            var hours = Math.floor(remainingTime / 3600);
            var minutes = Math.floor((remainingTime % 3600) / 60);
            var seconds = remainingTime % 60;

            // Pad hours, minutes, and seconds with leading zeros if necessary
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update the countdown display
            document.getElementById('countdown').innerHTML = "{{ __('Time remaining until the ban is lifted:') }} " +
                hours + ':' + minutes + ':' + seconds;

            // Decrement the remaining time and schedule the next update
            remainingTime--;
            setTimeout(updateCountdown, 1000);
        }

        // Start the countdown
        updateCountdown();
    </script>
</body>

</html>
