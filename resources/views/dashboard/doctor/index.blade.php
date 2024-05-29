<x-app-layout>
    @push('style')
        <style>
            .datepicker {
                font-family: Arial, sans-serif;
                background-color: #fff;
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 10px;
            }

            .datepicker table {
                width: 100%;
                border-collapse: collapse;
            }

            .datepicker th,
            .datepicker td {
                text-align: center;
                padding: 8px;
            }

            .datepicker th {
                font-weight: bold;
                color: #333;
                border-bottom: 2px solid #ccc;
            }

            .datepicker td {
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .datepicker td:hover {
                background-color: #f0f0f0;
            }

            .datepicker td.active {
                background-color: #8b4513;
                color: #fff;
            }

            .datepicker td.today {
                background-color: #f0f0f0;
            }

            .datepicker-switch {
                font-size: 1.2rem;
                font-weight: bold;
                color: #333;
                padding: 10px 0;
                text-align: center;
                border-bottom: 2px solid #ccc;
            }

            /* تنسيق شهور السنة */
            .datepicker-months .month {
                display: inline-block;
                width: 50px;
                /* تحديد عرض الشهور */
                margin: 5px;
                /* تحديد المسافة بين الشهور */
                text-align: center;
                cursor: pointer;
                font-size: 14px;
                /* حجم الخط */
                line-height: 30px;
                /* ارتفاع السطر */
                border-radius: 5px;
                /* تدوير الحواف */
                background-color: #f0f0f0;
                /* لون خلفية الشهور */
                transition: background-color 0.3s ease;
                /* تحديد سرعة التحول */
            }

            .datepicker-months .month:hover {
                background-color: #e0e0e0;
                /* لون خلفية الشهور عند التحويل */
            }

            .datepicker-months .focused {
                background-color: #8b4513;
                /* لون الشهر الحالي */
                color: #fff;
                /* لون النص في الشهر الحالي */
            }

            .datepicker-months .month:first-child {
                margin-left: 0;
                /* إزالة المسافة اليسارية لأول شهر */
            }

            .datepicker-months .month:last-child {
                margin-right: 0;
                /* إزالة المسافة اليمنى لأخر شهر */
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Doctors') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Create a new doctor') }}</span>
            </button>
        </h2>
    </x-slot>

    <!-- Modal -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ __('Add a new Doctors window') }}
                    </h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_ar" class="form-label">
                                {{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In Arabic') }}
                            </label>
                            <input type="text" id="name_ar" class="form-control"
                                placeholder="{{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In Arabic') }}">
                        </div>
                        <div class="mb-3">
                            <label for="name_en" class="form-label">
                                {{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In English') }}
                            </label>
                            <input type="text" class="form-control" id="name_en"
                                placeholder="{{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In English') }}">
                        </div>

                        <div class="mb-3">
                            <label for="work_start_date" class="form-label">
                                {{ __('Enter') }} {{ __('Work start date') }}
                            </label>
                            <input type="text" class="form-control" id="work_start_date"
                                placeholder="{{ __('Enter') }}  {{ __('Work start date') }}">
                        </div>


                        <div class="mb-3">
                            <label for="start_time" class="form-label">
                                {{ __('Enter') }} {{ __('Hour of start of work') }}
                            </label>
                            <input type="text" class="form-control start_time" id="start_time"
                                placeholder="{{ __('Enter') }}  {{ __('Hour of start of work') }}">
                        </div>

                        <div class="mb-3">
                            <label for="national_id" class="form-label">
                                {{ __('Enter') }} {{ __('National id') }}
                            </label>
                            <input type="text" class="form-control" id="national_id"
                                placeholder="{{ __('Enter') }}  {{ __('National id') }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                {{ __('Enter') }} {{ __('phone number') }}
                            </label>
                            <input type="text" class="form-control" id="phone"
                                placeholder="{{ __('Enter') }}  {{ __('phone number') }}">
                        </div>


                        <div class="mb-3">
                            <label for="select" class="form-label">
                                {{ __('Select the section it belongs to') }}
                            </label>
                            <select class="form-control form-select form-select-solid" id="select">
                                @foreach ($Category as $c)
                                    <option value="{{ $c->id }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <div class="fv-row mb-8">
                                <label class="required fs-6 fw-semibold mb-2">
                                    {{ __('Determine the days on which the doctor visits') }}
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day7">

                                    <label class="form-check-label mt-2 mb-2" for="day7">
                                        {{ __('Saturday') }}
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day1">

                                    <label class="form-check-label mt-2 mb-2" for="day1">
                                        {{ __('Sunday') }}
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day2">

                                    <label class="form-check-label mt-2 mb-2" for="day2">
                                        {{ __('Monday') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day3">

                                    <label class="form-check-label mt-2 mb-2" for="day3">
                                        {{ __('Tuesday') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day4">

                                    <label class="form-check-label mt-2 mb-2" for="day4">
                                        {{ __('Wednesday') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day5">

                                    <label class="form-check-label mt-2 mb-2" for="day5">
                                        {{ __('Thursday') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input mt-2 mb-2" type="checkbox" id="day6">

                                    <label class="form-check-label mt-2 mb-2" for="day6">
                                        {{ __('Friday') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Close') }}
                        </button>
                        <button type="button" class="btn btn-primary" onclick="store()">
                            {{ __('Add New Doctor') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'name', 'National id', 'Phone Number', 'Dependent section', 'Status', 'Action']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->national_id }}</td>
                            <td>{{ $row->phone_number }}</td>
                            <td>{{ $row->Category->name }}</td>

                            <td>
                                <span class="doctor-status-toggle" data-doctor-id="{{ $row->id }}"
                                    data-current-status="{{ $row->status }}" style="cursor: pointer;">
                                    @if ($row->status == 'Active')
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </span>
                            </td>


                            <td>
                                @can('Active-Doctors')
                                    <div class="no-effect-on-button" style="display: inline-block"
                                        id="blocked_{{ $row->id }}">
                                        <button type="button"
                                            class="btn {{ $row->status == 'Active' ? 'btn-danger' : 'btn-success' }} toggle-doctor-status"
                                            data-doctor-id="{{ $row->id }}"
                                            data-current-status="{{ $row->status }}">
                                            @if ($row->status == 'Active')
                                                <i class="fas fa-ban"></i>
                                            @else
                                                <i class="fas fa-check-circle"></i>
                                            @endif
                                        </button>
                                    </div>
                                @endcan
                                @can('Update-Doctors')
                                    <button type="button" onclick="fetchAndOpenEditModal({{ $row->id }})"
                                        class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcan

                                @can('Delete-Doctors')
                                    <a href="#" onclick="confirmDestroy({{ $row->id }}, this)"
                                        class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Doctor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_name_ar" class="form-label">
                                                    {{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In Arabic') }}
                                                </label>
                                                <input type="text" id="edit_name_ar" class="form-control"
                                                    placeholder="{{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In Arabic') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_name_en" class="form-label">
                                                    {{ __('Enter') }} {{ __('Name Doctor') }}
                                                    {{ __('In English') }}
                                                </label>
                                                <input type="text" class="form-control" id="edit_name_en"
                                                    placeholder="{{ __('Enter') }} {{ __('Name Doctor') }} {{ __('In English') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_work_start_date" class="form-label">
                                                    {{ __('Enter') }} {{ __('Work start date') }}
                                                </label>
                                                <input type="text" class="form-control" id="edit_work_start_date"
                                                    placeholder="{{ __('Enter') }}  {{ __('Work start date') }}">
                                            </div>


                                            <div class="mb-3">
                                                <label for="edit_start_time" class="form-label">
                                                    {{ __('Enter') }} {{ __('Hour of start of work') }}
                                                </label>
                                                <input type="text" class="form-control start_time"
                                                    id="edit_start_time"
                                                    placeholder="{{ __('Enter') }}  {{ __('Hour of start of work') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_national_id" class="form-label">
                                                    {{ __('Enter') }} {{ __('National id') }}
                                                </label>
                                                <input type="text" class="form-control" id="edit_national_id"
                                                    placeholder="{{ __('Enter') }}  {{ __('National id') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_phone" class="form-label">
                                                    {{ __('Enter') }} {{ __('phone number') }}
                                                </label>
                                                <input type="text" class="form-control" id="edit_phone"
                                                    placeholder="{{ __('Enter') }}  {{ __('phone number') }}">
                                            </div>


                                            <div class="mb-3">
                                                <label for="edit_select" class="form-label">
                                                    {{ __('Select the section it belongs to') }}
                                                </label>
                                                <select class="form-control form-select form-select-solid"
                                                    id="edit_select">
                                                    @foreach ($Category as $c)
                                                        <option value="{{ $c->id }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            {{ $c->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                                <div class="fv-row mb-8">
                                                    <label class="required fs-6 fw-semibold mb-2">
                                                        {{ __('Determine the days on which the doctor visits') }}
                                                    </label>
                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day7">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day7">
                                                            {{ __('Saturday') }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day1">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day1">
                                                            {{ __('Sunday') }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day2">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day2">
                                                            {{ __('Monday') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day3">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day3">
                                                            {{ __('Tuesday') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day4">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day4">
                                                            {{ __('Wednesday') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day5">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day5">
                                                            {{ __('Thursday') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                            id="edit_day6">

                                                        <label class="form-check-label mt-2 mb-2" for="edit_day6">
                                                            {{ __('Friday') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="modal-footer" id="modal-footer">

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </x-table>

            </div>
        </div>
    </div>
    @push('JS')
        <script>
            // تحديث القيمة لجميع الخانات checkbox
            function updateDefaultValues() {
                // جلب جميع الخانات checkbox
                var checkboxes = document.querySelectorAll('.form-check-input');

                // تعيين القيمة الافتراضية 0 لكل checkbox
                checkboxes.forEach(function(checkbox) {
                    checkbox.value = 0;
                });
            }

            // استدعاء وظيفة تحديث القيم عند تغيير حالة أي checkbox
            function updateValue() {
                // جلب جميع الخانات checkbox
                var checkboxes = document.querySelectorAll('.form-check-input');

                // تحديث القيم بناءً على حالة الاختيار
                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            this.value = 1; // في حال تحديد الخانة، تكون القيمة 1
                        } else {
                            this.value = 0; // في حال عدم تحديد الخانة، تكون القيمة 0
                        }
                    });
                });
            }

            // استدعاء الوظيفتين عند تحميل الصفحة
            window.onload = function() {
                updateDefaultValues(); // تعيين القيم الافتراضية
                updateValue(); // تحديث القيم عند تغيير حالة الخانات
            };
        </script>
        <script>
            $(document).ready(function() {
                $('#work_start_date').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format
                    autoclose: true,
                    todayHighlight: true
                });
            });
            $(document).ready(function() {
                $('#edit_work_start_date').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format
                    autoclose: true,
                    todayHighlight: true
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            // Initialize Flatpickr with time picker options
            flatpickr(".start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i K", // تنسيق الوقت مع عرض AM/PM
                defaultDate: "08:00", // تعيين الوقت الافتراضي إلى الساعة 8:30 صباحًا
                time_24hr: false, // تمكين تنسيق 12 ساعة بدلاً من 24 ساعة
                enable: [{
                    from: "08:00",
                    to: "12:00"
                }], // تمكين الفترة الصباحية (AM) فقط
                disable: [{
                    from: "12:00",
                    to: "23:59"
                }] // تعطيل الفترة المسائية (PM) بالكامل
            });
        </script>
        <script>
            function fetchAndOpenEditModal(id) {
                axios.get('doctor/edit/' + id)
                    .then(response => {
                        const doctor = response.data.doctor;

                        let parentElement2 = document.getElementById("modal-footer");
                        parentElement2.innerHTML = '';
                        let parentElement = document.getElementById("modal-footer");

                        // استخدام القوالب النصية لإنشاء عنصر الزر Close
                        parentElement.innerHTML += `
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('Close') }}
                            </button>
                        `;

                        // استخدام القوالب النصية لإنشاء عنصر الزر Update
                        parentElement.innerHTML += `
                            <button type="button" class="btn btn-primary" id="updatebutton" onclick="update(${id})">
                                {{ __('Update Doctor Data') }}
                            </button>
                        `;

                        // جلب قيمة name_ar من الكائن doctor
                        const name_ar = doctor.name.ar;
                        document.getElementById('edit_name_ar').value = name_ar;
                        const name_en = doctor.name.en;
                        document.getElementById('edit_name_en').value = name_en;
                        const work_start_date = doctor.start_date;
                        document.getElementById('edit_work_start_date').value = work_start_date;
                        const national_id = doctor.national_id;
                        document.getElementById('edit_national_id').value = national_id;
                        const startTime = doctor.start_time;
                        const [time, ampm] = startTime.split(" "); // Splitting the time string into an array
                        // Displaying the time and AM/PM indicator
                        console.log("Time:", time); // "08:00"
                        console.log("AM/PM:", ampm); // "AM"

                        flatpickr("#edit_start_time", {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i K", // تنسيق الوقت مع عرض AM/PM
                            defaultDate: time, // Include AM/PM indicator in defaultDate
                            time_24hr: false, // تمكين تنسيق 12 ساعة بدلاً من 24 ساعة
                            enable: [{
                                from: "08:00",
                                to: "12:00"
                            }], // تمكين الفترة الصباحية (AM) فقط
                            disable: [{
                                from: "12:00",
                                to: "23:59"
                            }] // تعطيل الفترة المسائية (PM) بالكامل
                        });

                        const phone_number = doctor.phone_number;
                        document.getElementById('edit_phone').value = phone_number;

                        const categoriesId = doctor.categories_id;
                        // Set the selected option in the select element
                        document.getElementById('edit_select').value = categoriesId;

                        const days = doctor.day[0];
                        const doctor_id = days ? days.doctor_id :
                            null; // التحقق من وجود القيمة قبل الوصول إلى خاصية "doctor_id"

                        for (let i = 1; i <= 7; i++) {
                            const dayCheckbox = document.getElementById('edit_day' + i);
                            if (doctor_id === id) {
                                if (days['day' + i] === 1) { // فحص إذا كانت القيمة تساوي 1
                                    dayCheckbox.checked = true;
                                } else {
                                    dayCheckbox.checked = false;
                                }
                            } else {
                                dayCheckbox.checked = false;
                            }
                        }

                    })
                    .catch(error => {
                        console.error('There was a problem with the Axios request:', error);
                        // Handle error scenario here
                    });
            }
        </script>
        <script>
            function store() {
                let formData = new FormData();
                formData.append('name_ar', document.getElementById('name_ar').value);
                formData.append('name_en', document.getElementById('name_en').value);
                formData.append('work_start_date', document.getElementById('work_start_date').value);
                formData.append('start_time', document.getElementById('start_time').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('national_id', document.getElementById('national_id').value);

                formData.append('select', document.getElementById('select').value);
                if (document.getElementById('day7').checked) {
                    formData.append('day7', document.getElementById('day7').value);
                }
                if (document.getElementById('day1').checked) {
                    formData.append('day1', document.getElementById('day1').value);
                }
                if (document.getElementById('day2').checked) {
                    formData.append('day2', document.getElementById('day2').value);
                }
                if (document.getElementById('day3').checked) {
                    formData.append('day3', document.getElementById('day3').value);
                }
                if (document.getElementById('day4').checked) {
                    formData.append('day4', document.getElementById('day4').value);
                }
                if (document.getElementById('day5').checked) {
                    formData.append('day5', document.getElementById('day5').value);
                }
                if (document.getElementById('day6').checked) {
                    formData.append('day6', document.getElementById('day6').value);
                }
                axios.post('doctor/create', formData)
                    .then(function(response) {
                        toastr.success(response.data.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                        toastr.error(error.response.data.message);
                    })
                    .then(function() {
                        // always executed
                    });
            }
        </script>
        <script>
            function update(id) {
                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('name_ar', document.getElementById('edit_name_ar').value);
                formData.append('name_en', document.getElementById('edit_name_en').value);
                formData.append('work_start_date', document.getElementById('edit_work_start_date').value);
                formData.append('start_time', document.getElementById('edit_start_time').value);
                formData.append('phone', document.getElementById('edit_phone').value);
                formData.append('national_id', document.getElementById('edit_national_id').value);
                formData.append('select', document.getElementById('edit_select').value);
                if (document.getElementById('edit_day7').checked) {
                    formData.append('day7', document.getElementById('edit_day7').value);
                }
                if (document.getElementById('edit_day1').checked) {
                    formData.append('day1', document.getElementById('edit_day1').value);
                }
                if (document.getElementById('edit_day2').checked) {
                    formData.append('day2', document.getElementById('edit_day2').value);
                }
                if (document.getElementById('edit_day3').checked) {
                    formData.append('day3', document.getElementById('edit_day3').value);
                }
                if (document.getElementById('edit_day4').checked) {
                    formData.append('day4', document.getElementById('edit_day4').value);
                }
                if (document.getElementById('edit_day5').checked) {
                    formData.append('day5', document.getElementById('edit_day5').value);
                }
                if (document.getElementById('edit_day6').checked) {
                    formData.append('day6', document.getElementById('edit_day6').value);
                }
                axios.post('doctor/update/' + id, formData)
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        toastr.success(response.data.message);
                        setTimeout(function() {
                            window.location.href = 'doctor';
                        }, 1100);

                    }, 10000)
                    .catch(function(error) {
                        // handle error
                        document.getElementById('updatebutton').disabled = false;
                        console.log(error);
                        toastr.error(error.response.data.message);
                    })
                    .then(function() {
                        // always executed
                    });
            }

            function confirmDestroy(id, referince) {
                Swal.fire({
                    title: "{{ __('Are you sure ?') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    text: "{{ __('!!!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes, delete it !') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        destroy(id, referince);
                    }
                })
            }

            function destroy(id, referince) {
                axios.delete('doctor/delete/' + id)
                    .then(function(response) {
                        console.log(response);
                        referince.closest('tr').remove();
                        ShowMessage(response.data);
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                        ShowMessage(error.response.data);
                    })
            }

            function ShowMessage(data) {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                    showConfirmButton: false,
                    timer: 1500
                })
            }


            function toggleDoctorStatus(button) {
                var doctorId = button.getAttribute('data-doctor-id');
                var currentStatus = button.getAttribute('data-current-status');
                var newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

                axios.put('update-doctor-status/' + doctorId, {
                        status: newStatus
                    })
                    .then(function(response) {
                        console.log(response.data.status)
                        setTimeout(function() {
                            window.location.href = 'doctor';
                        });
                    })
                    .catch(function(error) {
                        console.error('Error updating doctor status:', error);
                    });
            }

            document.addEventListener("DOMContentLoaded", function() {
                var toggleButtons = document.querySelectorAll('.toggle-doctor-status');

                toggleButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        toggleDoctorStatus(button);
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
