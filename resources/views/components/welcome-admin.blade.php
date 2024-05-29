@push('style')
    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

<div class="container mx-auto px-4 py-8">
    <!-- شريط الترحيب بالأدمين -->
    <div class="flex justify-between items-center mb-8 bg-blue-500 text-white py-4 px-6 rounded-lg shadow-lg fade-in">
        <div>
            <h1 class="text-3xl font-bold"><i class="fas fa-user-cog mr-2"></i> {{ __('Welcome') }}،
                {{ Auth::user()->name }}!</h1>
            <p>{{ __('Welcome to your admin control panel in a military hospital') }}.</p>
            <p class="time">{{ __('The time is now') }}: <span id="current-time"></span></p>
        </div>
    </div>

    <!-- مربعات لعرض معلومات الأدمين -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 fade-in" style="animation-delay: 0.5s;">
        <div
            class="bg-white p-6 rounded-lg shadow text-center transition duration-500 ease-in-out transform hover:scale-105 card">
            <p class="text-2xl font-bold">
                @php
                    use App\Models\Categories;
                    echo $departmentCount = Categories::count();
                @endphp
            </p>
            <p>
                {{ __('Number of departments') }}
            </p>
        </div>
        <div
            class="bg-white p-6 rounded-lg shadow text-center transition duration-500 ease-in-out transform hover:scale-105 card">
            <p class="text-2xl font-bold">
                @php
                    use App\Models\Doctor;
                    echo $doctorCount = Doctor::count();
                @endphp
            </p>
            <p>
                {{ __('Number of doctors') }}
            </p>
        </div>
        <div
            class="bg-white p-6 rounded-lg shadow text-center transition duration-500 ease-in-out transform hover:scale-105 card">
            <p class="text-2xl font-bold">
                @php
                    use App\Models\Complaint;
                    echo $complaintCount = Complaint::count();
                @endphp
            </p>
            <p>
                {{ __('Number of complaints') }}
            </p>
        </div>
        <div
            class="bg-white p-6 rounded-lg shadow text-center transition duration-500 ease-in-out transform hover:scale-105 card">
            <p class="text-2xl font-bold">
                @php
                    use App\Models\Booking;
                    echo $bookingCount = Booking::count();
                @endphp
            </p>
            <p>
                {{ __('Number of bookings') }}
            </p>
        </div>
    </div>

    <!-- جدول يعرض آخر الحجوزات -->
    <div class="bg-white p-6 rounded-lg shadow fade-in" style="animation-delay: 1.5s;">
        <h2 class="text-lg font-semibold mb-4">
            {{ __('Last reservations') }}
        </h2>
        @php
            $Bookings = Booking::latest()->take(10)->get();
        @endphp
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-center">{{ __('Reservation ID') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('Patient Name') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('Patient Phone Number') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('Card Number') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('Booking Date') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('The date of application') }}</th>
                    <th class="px-4 py-2 text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($bookingCount == 0)
                    <tr>
                        <td colspan="7" class="text-center py-4 border border-gray-300 rounded-lg">
                            <p class="text-red-500 font-bold">{{ __('No bookings available') }}</p>
                        </td>
                    </tr>
                @else
                    @foreach ($Bookings as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->id }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->first_name }}
                                {{ $row->middle_name }} {{ $row->last_name }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->phone_number }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->id_number }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->date }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->created_at->format('m/d/Y') }}</td>
                            <td class="border py-2 text-center">
                                <a href="{{ route('doctor.invoice', $row->id) }}" class="btn btn-outline-dark">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('doctor.invoice_dawnlode', $row->id) }}" target="_blank"
                                    class="btn btn-secondary">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>
</div>

@push('JS')
    <script>
        function updateTime() {
            const currentTimeElement = document.getElementById('current-time');
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // الساعة 0 تكون 12
            const formattedTime = `${hours}:${minutes} ${ampm}`;
            currentTimeElement.textContent = formattedTime;
        }

        // تحديث الوقت عند تحميل الصفحة لأول مرة
        updateTime();

        // تحديث الوقت كل دقيقة
        setInterval(updateTime, 60000);
    </script>
@endpush
