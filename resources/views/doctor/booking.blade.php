<x-app-layout>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">

        <style>
            .a:hover {
                color: rgba(114, 99, 11, 0.916);
                font-size: 104%;
            }

            .filter-section {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .filter-section label {
                font-weight: bold;
                color: #4a5568;
            }

            .filter-section input,
            .filter-section select {
                border-radius: 6px;
                border: 1px solid #d1d5db;
                padding: 10px;
                margin-top: 4px;
                margin-bottom: 12px;
                width: 100%;
                color: #4a5568;
            }

            .filter-section button {
                background-color: #2563eb;
                color: white;
                padding: 10px 20px;
                border-radius: 6px;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
                width: 100%;
                margin-top: 25px;
            }

            .filter-section button:hover {
                background-color: #1d4ed8;
            }

            .table-container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .table-container table {
                width: 100%;
                border-collapse: collapse;
            }

            .table-container th,
            .table-container td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #e2e8f0;
            }

            .table-container th {
                background-color: #f7fafc;
                color: #4a5568;
                font-weight: bold;
            }

            .table-container tr:hover {
                background-color: #f1f5f9;
            }

            .table-container td:last-child {
                display: flex;
                gap: 10px;
            }

            .table-container a.btn {
                padding: 5px 10px;
                border-radius: 6px;
                text-decoration: none;
                color: #ffffff;
            }

            .table-container a.btn-outline-dark {
                background-color: #4a5568;
            }

            .table-container a.btn-outline-dark:hover {
                background-color: #2d3748;
            }

            .table-container a.btn-secondary {
                background-color: #6b7280;
            }

            .table-container a.btn-secondary:hover {
                background-color: #4b5563;
            }

            /* ببداية الهبد في الجدول  */
            .table-container {
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                direction: rtl;
            }

            .dataTables_wrapper .row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 15px;
            }

            .dt-buttons .dt-button {
                background-color: #01332e !important;
                color: #fff;
                border-radius: 5px;
                font-size: 14px;
            }

            .dt-buttons .dt-button:hover {
                background-color: #0056b3 !important;
            }

            .dataTables_length label {
                font-size: 14px;
                color: #333;
            }

            .dataTables_length select {
                margin-left: 5px;
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ddd;
            }

            .table {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }

            .table thead {
                background-color: #343a40;
                color: #fff;
            }

            .table th,
            .table td {
                padding: 10px;
                text-align: center;
                border: 1px solid #dee2e6;
            }

            .table tbody tr:nth-child(odd) {
                background-color: #f8f9fa;
            }

            .table tbody tr:hover {
                background-color: #e9ecef;
            }

            .btn-outline-dark {
                color: #343a40;
                border: 1px solid #343a40;
                padding: 5px 10px;
                border-radius: 5px;
                transition: background-color 0.3s, color 0.3s;
            }

            .btn-outline-dark:hover {
                background-color: #343a40;
                color: #fff;
            }

            .btn-secondary {
                color: #fff;
                background-color: #6c757d;
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            .btn-secondary:hover {
                background-color: #5a6268;
            }

            .dataTables_info {
                font-size: 14px;
                color: #333;
            }

            .dataTables_paginate a {
                color: #007bff;
                text-decoration: none;
                margin: 0 5px;
                padding: 5px 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            .dataTables_paginate a:hover {
                background-color: #e9ecef;
            }

            .dataTables_paginate .current {
                background-color: #007bff;
                color: #fff;
                border: 1px solid #007bff;
            }

            /* تحسين شكل الجدول */
            #example2 {
                width: 100%;
                margin-top: 20px;
                /* تضاف المسافة بين الجدول والعناصر السابقة */
                border-collapse: collapse;
                /* إلغاء تقسيم الحدود بين الخلايا */
            }

            #example2 th,
            #example2 td {
                padding: 12px;
                text-align: center;
            }

            #example2 thead th {
                background-color: #343a40;
                /* لون الهيدر */
                color: #ffffff;
                /* لون النص في الهيدر */
            }

            #example2 tbody tr:nth-child(even) {
                background-color: #f8f9fa;
                /* لون الصفوف الزوجية */
            }

            #example2 tbody tr:hover {
                background-color: #e9ecef;
                /* لون الصفوف عند التحويم */
            }

            /* تحسين الخلايا في حال تم استخدام اللغة العربية */
            #example2 td {
                font-family: 'Cairo', sans-serif;
                /* اختيار الخط الملائم للنص العربي */
            }

            /* تحسين تصميم حقول البحث وعدد العناصر المعروضة */
            .dataTables_length select,
            .dataTables_filter input {
                border-radius: 5px;
                margin-bottom: 10px;
                padding: 5px;
                border: 1px solid #ced4da;
            }

            /* تحسين تصميم البيانات في وضع الريسبونسيف */
            @media (max-width: 767px) {
                #example2 thead {
                    display: none;
                    /* إخفاء الهيدر عند العرض الصغير */
                }

                #example2 tbody td {
                    display: block;
                    text-align: right;
                    /* محاذاة النص إلى اليمين في حال استخدام اللغة العربية */
                    position: relative;
                    padding-left: 50%;
                    white-space: nowrap;
                }

                #example2 tbody td:before {
                    content: attr(data-label);
                    position: absolute;
                    left: 0;
                    width: 45%;
                    padding-left: 15px;
                    font-weight: bold;
                    white-space: nowrap;
                    text-align: left;
                }
            }



            /* تنسيق للجدول */
            .table-container {
                padding: 20px;
                background-color: #ffffff;
                /* لون خلفية بيضاء لحاوية الجدول */
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            /* تحسين شكل حاويات البيانات */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 20px;
            }

            .dataTables_wrapper .dataTables_info {
                margin-top: 20px;
            }

            .dataTables_wrapper .dataTables_paginate {
                margin-top: 20px;
                text-align: center;
                /* توسيط الأزرار */
            }

            /* تنسيق pagination */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background-color: #007bff;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                color: white;
                padding: 6px 12px;
                margin: 0 2px;
                cursor: pointer;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background-color: #343a40;
                color: white;
            }

            select {
                background-position: left 0.5rem center !important;
            }

            div.dataTables_wrapper div.dataTables_length select {
                width: 52% !important;
            }

            #example2_length {
                float: right !important;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="flex items-center justify-between text-xl font-semibold leading-tight text-gray-800">
            {{ __('Working hours details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="date_field" class="block text-sm font-medium">{{ __('Select Date Field') }}</label>
                        <select id="date_field" class="mt-1 block w-full">
                            <option value="5">{{ __('Booking Date') }}</option>
                            <option value="6">{{ __('The date of application') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium">{{ __('Start Date') }}</label>
                        <input type="text" id="start_date" class="mt-1 block w-full flatpickr">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium">{{ __('End Date') }}</label>
                        <input type="text" id="end_date" class="mt-1 block w-full flatpickr">
                    </div>
                    <div>
                        <label for="patient_name" class="block text-sm font-medium"> {{ __('Patient Name') }}</label>
                        <input type="text" id="patient_name" class="mt-1 block w-full">
                    </div>
                    <div>
                        <label for="patient_phone" class="block text-sm font-medium">{{ __('Patient Name') }}</label>
                        <input type="text" id="patient_phone" class="mt-1 block w-full">
                    </div>
                    <div>
                        <label for="id_number" class="block text-sm font-medium">{{ __('Card Number') }}</label>
                        <input type="text" id="id_number" class="mt-1 block w-full">
                    </div>
                    <div class="flex items-end">
                        <button id="filter" class="mt-1 block w-full">Filter</button>
                    </div>
                </div>
            </div>
            <div class="table-container">
                <!-- Table Section -->
                <div class="table-container">
                    <x-table :tableId="'example2'" :columns="[
                        '#',
                        'Reservation ID',
                        'Patient Name',
                        'Patient Phone Number',
                        'Card Number',
                        'Booking Date',
                        'The date of application',
                        'Action',
                    ]">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->first_name }} {{ $row->middle_name }} {{ $row->last_name }}</td>
                                <td>{{ $row->phone_number }}</td>
                                <td>{{ $row->id_number }}</td>
                                <td>{{ $row->date }}</td>
                                <td>{{ $row->created_at->format('m/d/Y') }}</td>
                                <td>
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
                    </x-table>
                </div>
            </div>
        </div>

        @push('JS')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

            <script>
                // Initialize flatpickr
                flatpickr(".flatpickr", {
                    dateFormat: "Y-m-d",
                });

                // Initialize DataTables
                $(document).ready(function() {

                    var table = $('#example2').DataTable({
                        dom: '<"row"<"col-md-4"l><"col-md-4"B>>tip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        pageLength: 10,
                        lengthMenu: [5, 10, 25, 50, 100]
                    });

                    // Custom filtering function
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var dateField = $('#date_field').val();
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            var patientName = $('#patient_name').val().toLowerCase();
                            var patientPhone = $('#patient_phone').val();
                            var idNumber = $('#id_number').val();

                            var date = new Date(data[dateField]);
                            var start = new Date(startDate);
                            var end = new Date(endDate);
                            var name = data[1].toLowerCase();
                            var phone = data[2];
                            var card = data[3];

                            if (
                                (startDate === '' || endDate === '' || (date >= start && date <= end)) &&
                                (patientName === '' || name.includes(patientName)) &&
                                (patientPhone === '' || phone.includes(patientPhone)) &&
                                (idNumber === '' || card.includes(idNumber))
                            ) {
                                return true;
                            }
                            return false;
                        }
                    );

                    // Filter button click event
                    $('#filter').click(function() {
                        table.draw();
                    });
                });
            </script>
        @endpush
</x-app-layout>
