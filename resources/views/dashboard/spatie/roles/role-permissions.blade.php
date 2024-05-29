<x-app-layout>


    @push('style')
        <style>
            .form-check {
                text-align: center;
            }

            .form-check {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
            }

            .form-check-input {
                margin: 0;
            }

            .form-check-input {
                border: 1px solid transparent;
                box-shadow: 0 0 0 2px rgb(182, 180, 180);

            }

            .form-check-input:checked {
                box-shadow: 0 0 0 2px #0d6efd;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Roles') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Create a new Role') }}</span>
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
                        {{ __('Add a new Role window') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="create-role-form">
                        <!-- Role Name -->
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700">{{ __('Role Name') }}</label>
                            <input type="text" name="role-name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Enter role name">
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
                    <button type="button" class="btn btn-primary" onclick="store()">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'name', 'Guard', 'Permissions']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $row->name }}</td>
                            <td>
                                @if ($row->guard_name == 'web')
                                    <span class="badge bg-success"> {{ __('Admin') }}</span>
                                @else
                                    <span class="badge bg-success">{{ __("$row->guard_name") }}</span>
                                @endif
                            </td>
                            <td>

                                <div class="form-check">
                                    <input class="form-check-input"
                                        onchange="assignPermission({{ $role->id }}, {{ $row->id }})"
                                        type="checkbox" value="" id="flexCheckChecked"
                                        @if ($row->assigned) checked @endif>
                                    <label class="form-check-label" for="flexCheckChecked">
                                    </label>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </x-table>

            </div>
        </div>
    </div>


    @push('JS')
        <script>
            function assignPermission(roleId, permissionId) {
                axios.post('/dashboard/roles/' + roleId + '/permissions', {
                        permission_id: permissionId
                    })
                    .then(function(response) {
                        // handle success 2xx
                        console.log(response);
                        toastr.success(response.data.message);
                    })
                    .catch(function(error) {
                        // handle error 4xx
                        console.log(error);
                        toastr.error(error.response.data.message);
                    })
                    .then(function() {
                        // always executed
                    });
            }
        </script>
    @endpush



</x-app-layout>
