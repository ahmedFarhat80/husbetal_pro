<x-app-layout>
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
                <x-table :tableId="'example'" :columns="['#', 'name', 'Guard', 'Permissions', 'Created At']">
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
                            <td>
                                <a href="{{ route('roles.permissions.index', $row->id) }}" class="btn btn-info">
                                    {{ __('Permissions') }}
                                    ({{ $row->permissions_count }})
                                </a>
                            </td>
                            <td>{{ $row->created_at }}</td>
                        </tr>
                    @endforeach
                </x-table>

            </div>
        </div>
    </div>


    @push('JS')
        <script>
            function store() {
                axios.post('roles', {
                        name: document.getElementById('name').value,
                        guard_name: document.getElementById('guards').value,
                    })
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        toastr.success(response.data.message);
                        window.location.href = "roles";
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
    @endpush



</x-app-layout>
