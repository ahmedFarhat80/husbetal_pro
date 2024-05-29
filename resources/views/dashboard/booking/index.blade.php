<x-app-layout>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">

        <style>
            .dataTables_wrapper .dataTables_length select {
                width: auto;
                display: inline-block;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.5rem 0.75rem;
                margin-left: 0.25rem;
                margin-right: 0.25rem;
                border-radius: 0.25rem;
                color: #fff;
                background-color: #007bff;
                border: 1px solid transparent;
                transition: background-color 0.2s;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background-color: #343a40;
                color: #fff;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            /* تحديد ارتفاع الخلية */
            .table-cell {
                padding-top: 1px;
            }

            /* تنسيق الزر */
            .action-button {
                display: inline-block;
                margin-right: 8px;
                padding: 6px 12px;
                border-radius: 4px;
                text-decoration: none;
            }

            div.dataTables_wrapper div.dataTables_length select {
                width: 40%;
                display: inline-block;
            }

            #example2_length {
                float: right !important;
            }

            select {
                background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e);
                background-position: left 0.5rem center !important;
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
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="date_field"
                            class="block text-sm font-medium text-gray-700">{{ __('Select Date Field') }}</label>
                        <select id="date_field"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="5">{{ __('Booking Date') }}</option>
                            <option value="6">{{ __('The date of application') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_date"
                            class="block text-sm font-medium text-gray-700">{{ __('Start Date') }}</label>
                        <input type="text" id="start_date"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm flatpickr focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="end_date"
                            class="block text-sm font-medium text-gray-700">{{ __('End Date') }}</label>
                        <input type="text" id="end_date"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm flatpickr focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="patient_name"
                            class="block text-sm font-medium text-gray-700">{{ __('Patient Name') }}</label>
                        <input type="text" id="patient_name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="patient_phone"
                            class="block text-sm font-medium text-gray-700">{{ __('Patient Phone') }}</label>
                        <input type="text" id="patient_phone"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="id_number"
                            class="block text-sm font-medium text-gray-700">{{ __('Card Number') }}</label>
                        <input type="text" id="id_number"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button id="filter"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Filter') }}</button>
                    </div>
                </div>
            </div>


            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-semibold text-center">{{ __('Reservations details') }}</h2>
                    @can('Delete-Reservations')
                        <div>
                            <button id="select-all"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Select All') }}</button>
                            <button id="deselect-all"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">{{ __('Deselect All') }}</button>
                            <button id="export-selected"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">{{ __('Export Selected To PDF') }}</button>

                            <button id="delete-selected"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">{{ __('Delete Selected') }}</button>
                        </div>
                    @endcan

                </div>
                <x-table :tableId="'example2'" :columns="[
                    '', // Main checkbox column
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
                        <tr data-id="{{ $row->id }}">
                            <td class="border py-2 text-center"><input type="checkbox" class="row-checkbox"
                                    data-id="{{ $row->id }}"></td>
                            <td class="border py-2 text-center">{{ ++$i }}</td>
                            <td class="border py-2 text-center">{{ $row->id }}</td>
                            <td class="border py-2 text-center">{{ $row->first_name }} {{ $row->middle_name }}
                                {{ $row->last_name }}</td>
                            <td class="border py-2 text-center">{{ $row->phone_number }}</td>
                            <td class="border py-2 text-center">{{ $row->id_number }}</td>
                            <td class="border py-2 text-center">{{ $row->date }}</td>
                            <td class="border py-2 text-center">{{ $row->created_at->format('m/d/Y') }}</td>
                            <td class="border py-2 text-center">

                                @can('view-PDF')
                                    <a href="{{ route('doctor.invoice', $row->id) }}" class="btn btn-outline-dark">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                &nbsp;
                                @can('Dawnlode-PDF')
                                    <a href="{{ route('doctor.invoice_dawnlode', $row->id) }}" target="_blank"
                                        class="btn btn-secondary">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                @endcan
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
                    dom: '<"row flex justify-between items-center mb-4"<"col-md-4"l><"col-md-4"B>>tip',
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
                        var patientPhone = $('#patient_phone').val().toLowerCase();
                        var idNumber = $('#id_number').val().toLowerCase();

                        var date = data[dateField].trim();
                        var name = data[3].toLowerCase();
                        var phone = data[4].toLowerCase();
                        var card = data[5].toLowerCase();

                        if ((startDate === "" || new Date(date) >= new Date(startDate)) &&
                            (endDate === "" || new Date(date) <= new Date(endDate)) &&
                            (patientName === "" || name.includes(patientName)) &&
                            (patientPhone === "" || phone.includes(patientPhone)) &&
                            (idNumber === "" || card.includes(idNumber))
                        ) {
                            return true;
                        }
                        return false;
                    }
                );

                // Apply filter
                $('#filter').click(function() {
                    table.draw();
                });

                // Select all checkboxes
                $('#select-all').on('click', function() {
                    $('.row-checkbox').prop('checked', true);
                });

                // Deselect all checkboxes
                $('#deselect-all').on('click', function() {
                    $('.row-checkbox').prop('checked', false);
                });



                // Delete selected
                $('#delete-selected').on('click', function() {
                    var selectedIds = [];
                    $('.row-checkbox:checked').each(function() {
                        selectedIds.push($(this).data('id'));
                    });
                    if (selectedIds.length === 0) {
                        alert('No rows selected');
                        return;
                    }
                    if (!confirm('Are you sure you want to delete the selected rows?')) {
                        return;
                    }
                    $.ajax({
                        url: '{{ route('delete.rows') }}', // Update the route to your delete function
                        method: 'POST',
                        data: {
                            ids: selectedIds,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Handle the response, e.g., refresh the table
                            $('.row-checkbox:checked').each(function() {
                                $(this).closest('tr').remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('Deleted successfully') }}",
                                showConfirmButton: false,
                                timer: 1500 // يغلق تلقائيا بعد 1.5 ثانية
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('Error deleting') }}",
                                showConfirmButton: false,
                                timer: 1500 // يغلق تلقائيا بعد 1.5 ثانية
                            });
                        }
                    });
                });

            });
        </script>


        <script>
            document.getElementById('export-selected').addEventListener('click', function() {
                var selectedIds = [];
                var checkboxes = document.querySelectorAll('.row-checkbox:checked');
                checkboxes.forEach(function(checkbox) {
                    var rowId = checkbox.closest('tr').getAttribute('data-id');
                    selectedIds.push(rowId);
                });

                selectedIds = selectedIds.filter(function(id) {
                    return id !== null;
                });

                if (selectedIds.length === 0) {
                    alert('No rows selected');
                    return;
                }

                axios.post('{{ route('export.pdf') }}', {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    })
                    .then(function(response) {
                        if (response.data.zip_url) {
                            // عرض رسالة تنبيه ناجحة باستخدام SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('Exported successfully') }}",
                                showConfirmButton: false,
                                timer: 2000, // يغلق التنبيه بعد 1.5 ثانية
                                timerProgressBar: true,
                                toast: true,
                                position: 'top-end',
                                background: '#4CAF50',
                                iconColor: '#FFFFFF',
                                customClass: {
                                    popup: 'swal2-popup-custom',
                                    title: 'swal2-title-custom',
                                    content: 'swal2-content-custom',
                                    confirmButton: 'swal2-confirm-button-custom'
                                }
                            });

                            // إنشاء وتنزيل رابط الملف المضغوط
                            var downloadLink = document.createElement('a');
                            downloadLink.href = response.data.zip_url;
                            downloadLink.download = 'invoices.zip';
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        } else {
                            // عرض رسالة تنبيه في حالة حدوث خطأ باستخدام SweetAlert2
                            Swal.fire({
                                icon: 'error',
                                title: 'Error exporting',
                                text: 'An error occurred while exporting. Please try again later.',
                                background: '#F44336',
                                iconColor: '#FFFFFF',
                                customClass: {
                                    popup: 'swal2-popup-custom',
                                    title: 'swal2-title-custom',
                                    content: 'swal2-content-custom',
                                    confirmButton: 'swal2-confirm-button-custom'
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        // عرض رسالة تنبيه في حالة حدوث خطأ باستخدام SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error exporting',
                            text: 'An error occurred while exporting. Please try again later.',
                            background: '#F44336',
                            iconColor: '#FFFFFF',
                            customClass: {
                                popup: 'swal2-popup-custom',
                                title: 'swal2-title-custom',
                                content: 'swal2-content-custom',
                                confirmButton: 'swal2-confirm-button-custom'
                            }
                        });
                    });


            });
        </script>
    @endpush
</x-app-layout>
