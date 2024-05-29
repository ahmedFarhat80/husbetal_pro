<x-app-layout>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <style>
            .a:hover {
                color: rgba(114, 99, 11, 0.916);
                font-size: 104%;
            }
        </style>
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Working hours details') }}
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
                        <div class="form-group">
                            <label for="appointmentDuration">{{ __('Appointment Duration (minutes)') }}</label>
                            <input type="text" class="form-control mt-2" id="duration" name="appointmentDuration"
                                placeholder="{{ __('Enter appointment duration') }}" value="{{ $time }}">
                        </div>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="updateDoctorDuration({{ Auth::id() }})">{{ __('Edit') }}</button>
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>

            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>

                <div>
                    {{ __('The booking period for one session is:') }} {{ $time }} {{ __('minute') }}
                    <span>
                        {{ __('Modify the reservation period') }} <a href="#" class="a"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                            style="transition: color 0.3s, font-size 0.3s;">{{ __('Press here') }}</a>


                    </span>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'today', 'Action']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                {{ $value }}
                            </td>
                            <td>
                                <a href="{{ route('doctor.timehour', $key) }}" class="btn btn-info">
                                    {{ __('Modifying booking hours') }}
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


        <script>
            function updateDoctorDuration(doctorId) {
                axios.put('update-doctor-duration/' + doctorId, {
                        duration: document.getElementById('duration').value,
                    })
                    .then(function(response) {
                        toastr.success(response.data.message);
                        setTimeout(function() {
                            window.location.href = 'time';
                        });
                    })
                    .catch(function(error) {
                        toastr.error(error.response.data.message);
                    });
            }
        </script>
    @endpush
</x-app-layout>
