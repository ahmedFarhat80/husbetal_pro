<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Permissions') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Create a new Permission') }}</span>
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
                        {{ __('Add a new Permission window') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="permission-form">
                        <!-- Permission Name -->
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700">{{ __('Permission Name') }}</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Enter permission name">
                        </div>
                        <!-- Guard Name -->
                        <div class="mb-4">
                            <label for="guards"
                                class="block text-sm font-medium text-gray-700">{{ __('Guard Name') }}</label>
                            <select name="guard-name" id="guards"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="web">{{ __('Admin') }}</option>
                                <option value="doctor">{{ __('Doctor') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="button" class="btn btn-primary" id="modal-submit-btn"
                        onclick="store()">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'Name', 'Guard', 'Created At', 'Action']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $row->name }}</td>
                            <td>
                                @if ($row->guard_name == 'web')
                                    {{ __('Admin') }}
                                @else
                                    {{ __("$row->guard_name") }}
                                @endif
                            </td>
                            <td>{{ $row->created_at }}</td>
                            <td>
                                @can('Update-Permissions')
                                    <button class="btn btn-outline-primary"
                                        onclick="editPermission({{ $row->id }}, '{{ $row->name }}', '{{ $row->guard_name }}')">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                @endcan

                                @can('Delete-Permissions')
                                    <button class="btn btn-outline-danger"
                                        onclick="confirmDestroy({{ $row->id }},this)">
                                        <i class="fa-solid fa-trash-alt"></i>
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
        <script>
            function store() {
                axios.post('permissions', {
                        name: document.getElementById('name').value,
                        guard_name: document.getElementById('guards').value,
                    })
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        toastr.success(response.data.message);
                        window.location.href = "permissions";
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

            function updatePermission(id) {
                axios.put('permissions/' + id, {
                        name: document.getElementById('name').value,
                        guard_name: document.getElementById('guards').value,
                    })
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        toastr.success(response.data.message);
                        window.location.href = "permissions";
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

            function editPermission(id, name, guard_name) {
                // Fill the modal with the current data
                document.getElementById('name').value = name;
                document.getElementById('guards').value = guard_name;

                // Change the modal button to update
                document.getElementById('modal-submit-btn').innerText = "{{ __('Update') }}";
                document.getElementById('modal-submit-btn').setAttribute('onclick', 'updatePermission(' + id + ')');

                // Show the modal
                $('#staticBackdrop').modal('show');
            }

            function confirmDestroy(id, reference) {
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
                        destroy(id, reference);
                    }
                });
            }

            function destroy(id, reference) {
                axios.delete('permissions/' + id)
                    .then(function(response) {
                        // handle success 2xx
                        console.log(response);
                        reference.closest('tr').remove();
                        showMessage(response.data);
                    })
                    .catch(function(error) {
                        // handle error 4xx
                        console.log(error);
                        showMessage(error.response.data)
                    })
                    .then(function() {
                        // always executed
                    });
            }

            function showMessage(data) {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        </script>
    @endpush
</x-app-layout>
