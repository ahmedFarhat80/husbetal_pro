@extends('frontend.welcome')

@section('container')
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>
        <div class="card w-100">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h2 class="text-center flex-grow-1">{{ __('Military Hospital appointments') }}</h2>
                <div class="language-switcher">
                    @if (session('lang') == 'ar')
                        <a href="{{ url('lang/en') }}" class="btn btn-sm btn-outline-light">{{ __('English') }}</a>
                    @else
                        <a href="{{ url('lang/ar') }}" class="btn btn-sm btn-outline-light">{{ __('العربية') }}</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info alert-dismissible fade show d-flex justify-content-between align-items-center"
                    role="alert">
                    {{ __('Selected section') }} : {{ $Category }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>

                <div class="tab-pane fade show active" id="step1">
                    <h4 class="pb-4 pt-1"> {{ __('Choose a doctor') }}</h4>

                    <div class="search-box">
                        <input type="text" class="form-control" id="searchInput" placeholder="{{ __('Find a doctor') }}"
                            oninput="searchDepartments()">
                    </div>
                    <div class="vertical-tabs">
                        <ul class="nav flex-column" id="clinicTabs" role="tablist">

                            @foreach ($doctors as $doctor)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="surgery-tab{{ $doctor->id }}" data-bs-toggle="tab"
                                        href="#surgery{{ $doctor->id }}" role="tab"
                                        aria-controls="surgery{{ $doctor->id }}" aria-selected="true"
                                        onclick="selectCategory('{{ $doctor->id }}')">
                                        {{ $doctor->name }}
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-custom-2 w-100 d-flex justify-content-center" onclick="brevesStep()">
                        {{ __('previous') }}

                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-custom w-100 d-flex justify-content-center" onclick="nextStep()">
                        {{ __('Next') }}
                    </button>
                </div>

            </div>

        </div>
    </div>
@endsection



@section('JS')
    <script>
        function brevesStep() {
            window.location.href = "/"; // التحويل والانتقال
        }
        toastr.options = {
            "positionClass": "toast-top-center", // Center-top position
            "timeOut": 3000, // 3 seconds timeout
        };
        toastr.success(
            "{{ __('The section is selected and we move to the second step') }}"
        );
    </script>
    <script>
        var selectedCategoryId;

        function selectCategory(categoryId) {
            selectedCategoryId = categoryId;
        }

        function nextStep() {
            axios.put('/doctor/1', {
                    doctoId: selectedCategoryId
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "/date"; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
