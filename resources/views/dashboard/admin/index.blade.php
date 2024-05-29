<x-app-layout>


    @push('style')
        <style>
            .btn-group[dir="rtl"] .btn:first-child {
                border-top-right-radius: 0.25rem;
                border-bottom-right-radius: 0.25rem;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .btn-group[dir="rtl"] .btn:last-child {
                border-top-left-radius: 0.25rem;
                border-bottom-left-radius: 0.25rem;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .btn-group[dir="ltr"] .btn:first-child {
                border-top-left-radius: 0.25rem;
                border-bottom-left-radius: 0.25rem;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .btn-group[dir="ltr"] .btn:last-child {
                border-top-right-radius: 0.25rem;
                border-bottom-right-radius: 0.25rem;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        </style>
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Admins') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Create a new Admin') }}</span>
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
                        {{ __('Add a new Admin window') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name_ar" class="form-label">
                                {{ __('Name') }} {{ __('In Arabic') }}
                            </label>
                            <input type="text" class="form-control" id="name_ar">
                        </div>

                        <div class="mb-3">
                            <label for="name_en" class="form-label">
                                {{ __('Name') }} {{ __('In English') }}
                            </label>
                            <input type="text" class="form-control" id="name_en">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                {{ __('Email') }}
                            </label>
                            <input type="email" class="form-control" id="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password">
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" onclick="store()">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-table :tableId="'example'" :columns="['#', 'Name In Arabic', 'Name In English', 'Email', 'Roles', 'Created At', 'Action']">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $row->getTranslation('name', 'ar') }}</td>
                            <td>{{ $row->getTranslation('name', 'en') }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                <select class="form-select" onchange="assignRole(this.value, {{ $row->id }})">
                                    @if (isset($row->roles) && count($row->roles) > 0)
                                        <option value="{{ $row->roles[0]->id }}" selected>{{ $row->roles[0]->name }}
                                        </option>
                                    @else
                                        <option value="">{{ __('Choose Role') }}</option>
                                    @endif

                                    @foreach ($roles as $role)
                                        @if (!isset($row->roles[0]) || $row->roles[0]->id != $role->id)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>

                            <td>{{ $row->created_at }}</td>
                            <td>
                                <div class="btn-group" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                    @can('Update-Admins')
                                        <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal" onclick="loadAdminData({{ $row->id }})">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('Delete-Admins')
                                        <a href="#" class="btn btn-danger"
                                            onclick="confirmDestroy({{ $row->id }}, this)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endcan
                                </div>

                                <!-- Include admin data in a hidden div -->
                                <div id="admin-data-{{ $row->id }}" style="display: none;">
                                    <div data-name-ar="{{ $row->getTranslation('name', 'ar') }}"
                                        data-name-en="{{ $row->getTranslation('name', 'en') }}"
                                        data-email="{{ $row->email }}"></div>
                                </div>


                            </td>
                        </tr>
                    @endforeach

                </x-table>
            </div>
        </div>
    </div>

    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">{{ __('Edit Admin') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-admin-form">
                        <div class="mb-3">
                            <label for="edit-name_ar" class="form-label">{{ __('Name') }}
                                {{ __('In Arabic') }}</label>
                            <input type="text" class="form-control" id="edit-name_ar">
                        </div>
                        <div class="mb-3">
                            <label for="edit-name_en" class="form-label">{{ __('Name') }}
                                {{ __('In English') }}</label>
                            <input type="text" class="form-control" id="edit-name_en">
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="edit-email">
                        </div>
                        <div class="mb-3">
                            <label for="edit-password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="edit-password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="updateAdmin()">{{ __('Save changes') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('JS')
        <script>
            function store() {
                axios.post('admin', {
                        name_ar: document.getElementById('name_ar').value,
                        name_en: document.getElementById('name_en').value,
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value,
                    })
                    .then(function(response) {
                        toastr.success(response.data.message);
                        document.getElementById('create-form').reset();
                        window.location.href = "Admin";
                    })
                    .catch(function(error) {
                        toastr.error(error.response.data.message);
                    });
            }

            function loadAdminData(adminId) {
                // Get data from the hidden div
                const adminData = document.querySelector(`#admin-data-${adminId} > div`);
                document.getElementById('edit-name_ar').value = adminData.getAttribute('data-name-ar');
                document.getElementById('edit-name_en').value = adminData.getAttribute('data-name-en');
                document.getElementById('edit-email').value = adminData.getAttribute('data-email');
                document.getElementById('edit-password').value = ''; // Leave password empty
                document.getElementById('edit-admin-form').dataset.id = adminId; // Store the admin ID
            }


            function updateAdmin() {
                let adminId = document.getElementById('edit-admin-form').dataset.id;
                axios.put('admin/' + adminId, {
                        name_ar: document.getElementById('edit-name_ar').value,
                        name_en: document.getElementById('edit-name_en').value,
                        email: document.getElementById('edit-email').value,
                        password: document.getElementById('edit-password').value,
                    })
                    .then(function(response) {
                        toastr.success(response.data.message);
                        window.location.reload();
                    })
                    .catch(function(error) {
                        toastr.error(error.response.data.message);
                    });
            }

            function assignRole(roleId, userId) {
                axios.post('/dashboard/assign-role', {
                        role_id: roleId,
                        user_id: userId
                    })
                    .then(function(response) {
                        toastr.success(response.data.message);
                    })
                    .catch(function(error) {
                        toastr.error(error.response.data.message);
                    });
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
                axios.delete('admin/' + id)
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
