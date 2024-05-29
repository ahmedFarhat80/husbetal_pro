<div class="py-12">
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        {{ __('Edit Section') }}
                    </h5>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name_ar" class="form-label">
                                {{ __('Enter') }} {{ __('Name Section') }} {{ __('In Arabic') }}
                            </label>
                            <input type="text" id="edit_name_ar" class="form-control"
                                placeholder="{{ __('Enter') }} {{ __('Name Section') }} {{ __('In Arabic') }}">
                        </div>

                        <div class="mb-3">
                            <input type="hidden" id="id" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="edit_name_en" class="form-label">
                                {{ __('Enter') }} {{ __('Name Section') }} {{ __('In English') }}
                            </label>
                            <input type="text" class="form-control" id="edit_name_en"
                                placeholder="{{ __('Enter') }} {{ __('Name Section') }} {{ __('In English') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Close') }}
                        </button>
                        <button type="button" class="btn btn-primary" onclick="updateSection()">
                            {{ __('Update') }} {{ __('Section') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-table :tableId="'example'" :columns="['#', 'name', 'Doctors Count', 'Action']">
                @php
                    $i = 0;
                @endphp
                @foreach ($data as $row)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ count($row->doctors) }}</td>
                        <td>
                            @can('Update-Sections')
                                <button type="button" onclick="fetchAndOpenEditModal({{ $row->id }})"
                                    class="btn btn-info">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            @endcan
                            @can('Delete-Sections')
                                <a href="#" onclick="confirmDestroy({{ $row->id }}, this)"
                                    class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
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
    <script>
        Livewire.on('closeModal', function() {
            // Your logic to close the modal, for example using Bootstrap modal methods
            $('#staticBackdrop').modal('hide');
        });
    </script>


    <script>
        function fetchAndOpenEditModal(id) {
            // Use Ajax to fetch data based on the ID
            axios.get('/dashboard/Section/' + id)
                .then(function(response) {
                    // Check if the response contains the expected data structure
                    if (response.data && response.data.name_ar && response.data.name_en) {
                        // Populate the modal fields with data from the server response
                        document.getElementById('edit_name_ar').value = response.data.name_ar;
                        document.getElementById('edit_name_en').value = response.data.name_en;
                        document.getElementById('id').value = response.data.id;

                        $('#editModal').modal('show');
                    } else {
                        console.error('Invalid server response:', response.data);
                    }
                })
                .catch(function(error) {
                    console.error('Error fetching data:', error);
                    // Handle the error case
                });
        }
    </script>
    <script>
        function addSection() {
            var name_ar = document.getElementById('name_ar').value;
            var name_en = document.getElementById('name_en').value;

            var sectionData = {
                name_ar: name_ar,
                name_en: name_en,
            };

            axios.post('/dashboard/Section', sectionData)
                .then(function(response) {
                    toastr.success(response.data.message);
                    $('#staticBackdrop').modal('hide');
                    window.location.href = '/dashboard/Section';
                })
                .catch(function(error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>

    <script>
        function updateSection() {
            var data = {
                name_ar: document.getElementById("edit_name_ar").value,
                name_en: document.getElementById("edit_name_en").value,
                id: document.getElementById("id").value
            };
            axios.put('/dashboard/Section/' + data['id'], data)
                .then(function(response) {
                    // console.log(data['id'])
                    toastr.success(response.data.message);
                    window.location.href = '/dashboard/Section';
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
        function confirmDestroy(id, reference) {
            Swal.fire({
                title: "{{ __('Are you sure ?') }}",
                text: "{{ __('!!!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "{{ __('Cancel') }}",
                confirmButtonText: "{{ __('Yes, delete it !') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, reference);
                }
            });
        }

        function destroy(id, reference) {
            axios.delete('/dashboard/Section/delete/' + id)
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
