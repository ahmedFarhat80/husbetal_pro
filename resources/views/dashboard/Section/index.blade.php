<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Sections') }}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2">{{ __('Create a new Section') }}</span>
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
                        {{ __('Add a new Sections window') }}
                    </h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_ar" class="form-label">
                                {{ __('Enter') }} {{ __('Name Section') }} {{ __('In Arabic') }}
                            </label>
                            <input type="text" id="name_ar" class="form-control"
                                placeholder="{{ __('Enter') }} {{ __('Name Section') }} {{ __('In Arabic') }}">
                        </div>
                        <div class="mb-3">
                            <label for="name_en" class="form-label">
                                {{ __('Enter') }} {{ __('Name Section') }} {{ __('In English') }}
                            </label>
                            <input type="text" class="form-control" id="name_en"
                                placeholder="{{ __('Enter') }} {{ __('Name Section') }} {{ __('In English') }}">
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Close') }}
                        </button>
                        <button type="button" class="btn btn-primary" onclick="addSection()">
                            {{ __('Add New Section') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <livewire: /> --}}
    @livewire('section-table')


    @livewireScripts

</x-app-layout>
