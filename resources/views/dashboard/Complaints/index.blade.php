<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Complaints Department') }}


        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-semibold text-center">{{ __('Reservations details') }}</h2>
                    {{--
                    <div>
                        <button id="select-all"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Select All') }}</button>
                        <button id="deselect-all"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">{{ __('Deselect All') }}</button>
                        <button id="export-selected"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">{{ __('Export Selected To PDF') }}</button>

                        <button id="delete-selected"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">{{ __('Delete Selected') }}</button>
                    </div> --}}
                </div>
                <x-table :tableId="'example'" :columns="[
                    '#',
                    'Name',
                    'Complaint Description',
                    'ID number',
                    'Patient Phone Number',
                    'Booking Date',
                    'Type of complaint',
                    'Action',
                ]">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr data-id="{{ $row->id }}">
                            <td class="border py-2 text-center">{{ ++$i }}</td>

                            <td class="border py-2 text-center">{{ $row->user_name }} </td>
                            <td class="border py-2 text-center">{{ $row->description }}</td>
                            <td class="border py-2 text-center">{{ $row->id_number }}</td>
                            <td class="border py-2 text-center">{{ $row->phone_number }}</td>
                            <td class="border py-2 text-center">{{ $row->created_at->format('m/d/Y') }}</td>
                            <td class="border py-2 text-center">
                                {{ __("$row->complaint_type") }}
                            </td>
                            <td class="border py-2 text-center">
                                @can('View-Complaints')
                                    <a href="{{ route('Complaint.view', $row->id) }}" class="btn btn-outline-dark">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @can('Delete-Complaints')
                                    <button onclick="confirmDestroy({{ $row->id }}, this)"
                                        class="btn btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan

                            </td>
                        </tr>
                    @endforeach

                </x-table>
            </div>



        </div>
    </div>
    @push('JS')
        <SCript>
            function confirmDestroy(id, referince) {
                //    console.log("ID:"+id)    // ->?   (id) تستعمل لفحص الكي اذا تم تمريرة او لا
                Swal.fire({
                    title: "{{ __('Are you sure ?') }}",
                    text: "{{ __('!!!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('Yes, delete it !') }}',
                    cancelButtonText: '{{ __('Cancel') }}' // تغيير نص زر الإلغاء هنا
                }).then((result) => {
                    if (result.isConfirmed) {
                        destroy(id, referince); // referince لاستقبال الذس من الرابط
                    }
                })
            }

            function destroy(id, referince) {
                axios.delete('Complaints/' + id)
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        referince.closest('tr')
                            .remove();
                        ShowMessage(response.data);
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                        ShowMessage(error.response.data);
                    })
                    .then(function() {

                    });

            }

            function ShowMessage(data) {
                Swal.fire({
                    icon: data.icon, // طباعة الايقونة والاعنوان بناء على البينات المستقبلة من الكنترولر
                    title: data.title,
                    text: data.text,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        </script>
    @endpush


</x-app-layout>
