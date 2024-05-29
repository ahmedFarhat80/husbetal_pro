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
                <div class="tab-pane fade show active" id="step1">
                    <h4 class="pb-4 pt-1"> {{ __('Select section') }}</h4>

                    <div class="search-box">
                        <input type="text" class="form-control" id="searchInput" placeholder="{{ __('Find a section') }}"
                            oninput="searchDepartments()">
                    </div>

                    <div class="vertical-tabs">
                        <ul class="nav flex-column" id="clinicTabs" role="tablist">
                            @foreach ($categories as $category)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="surgery-tab{{ $category->id }}" data-bs-toggle="tab"
                                        href="#surgery{{ $category->id }}" role="tab"
                                        aria-controls="surgery{{ $category->id }}" aria-selected="true"
                                        onclick="selectCategory('{{ $category->id }}')">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>

                </div>
            </div>
            <button class="btn btn-custom w-100 d-flex justify-content-center" onclick="nextStep()">
                {{ __('Next') }}
            </button>

        </div>
    </div>
@endsection



@section('JS')
    <script>
        var selectedCategoryId;

        function selectCategory(categoryId) {
            selectedCategoryId = categoryId;
        }

        function nextStep() {
            axios.post('/doctor', {
                    categoryId: selectedCategoryId
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "/doctor"; // التحويل والانتقال
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
