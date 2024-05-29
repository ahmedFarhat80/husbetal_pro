<x-app-layout>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Details and times of working sessions') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Add a new session') }}</span>
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
                        {{ __('Modify the reservation period') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <div class="mb-3">
                            <label for="sessionStartTime" class="form-label">{{ __('Session start time') }}</label>
                            <input type="text" id="timePicker" placeholder="Select Time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                {{ __('Session summary description in Arabic') }}
                                <span style="color: red; font-size: 12px"> {{ __('optional') }} </span>
                            </label>
                            <input type="text" class="form-control" id="description_ar" placeholder="">
                            <p class="form-text text-muted">
                                {{ __('This field can be used to provide a brief description of the session that is shown to people when they select the session') }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                {{ __('Session summary description in English') }}
                                <span style="color: red; font-size: 12px"> {{ __('optional') }} </span>
                            </label>
                            <input type="text" class="form-control" id="description_en" placeholder="">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="addTime('{{ $day }}')">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'Session start time', 'Session end time', 'Description', 'Action']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>
                                {{ ++$i }}
                            </td>

                            <td>
                                {{ $row->time }}

                            </td>

                            <td>
                                {{ date('h:i A', strtotime($row->time) + $add * 60) }}
                            </td>

                            <td>
                                {{ $row->description ?? __('There is no description') }}
                            </td>

                            <td>

                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        </div>
    </div>



    @push('JS')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            $(document).ready(function() {
                $('#timePicker').flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K", // "h" للساعة بنظام 12 ساعة و "K" لعرض AM/PM
                    time_24hr: false, // تفعيل نظام 12 ساعة
                    minTime: "08:00",
                    maxTime: "12:00"
                });
            });
        </script>


        <script>
            function addTime(day) {
                axios.post('duration/' + day, {
                        timePicker: document.getElementById('timePicker').value,
                        description_ar: document.getElementById('description_ar').value,
                        description_en: document.getElementById('description_en').value,
                    })
                    .then(function(response) {
                        toastr.success(response.data.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    })
                    .catch(function(error) {
                        toastr.error(error.response.data.message);
                    });
            }
        </script>
    @endpush
</x-app-layout>
