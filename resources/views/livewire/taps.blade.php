<div class="container">
    <div class="progress">
        <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
            :style="'width: ' + progressPercentage + '%;'" aria-valuenow="{{ $currentStep }}" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>

    <br>
    {{-- <!-- في القسم الخاص بالتبويبات -->
    <ul class="nav nav-tabs" id="myTabs">
        @for ($i = 1; $i <= 6; $i++)
            <li class="nav-item">
                <a class="nav-link{{ $currentStep >= $i ? ' active' : '' }}" id="tab{{ $i }}"
                    data-bs-toggle="tab" href="#step{{ $i }}" wire:click.prevent="prevStep"
                    @if ($currentStep <= $i) disabled @endif>
                    Step {{ $i }}
                </a>
            </li>
        @endfor
    </ul> --}}

    <div class="tab-content mt-2">
        <!-- خطوة 1 -->
        <div wire:loading.remove class="tab-pane fade @if ($currentStep == 1) show active @endif"
            id="step1">
            <!-- محتوى الخطوة 1 -->
            <h3>Choose Department</h3>
            @error('selectedCategory')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="departmentSelect" class="form-label">Select Department:</label>

                <div class="vertical-tabs">
                    <ul class="nav flex-column" id="clinicTabs" role="tablist">
                        @foreach ($categories as $category)
                            <li class="nav-item" role="presentation">
                                <a wire:click="selectCategory({{ $category->id }})"
                                    class="nav-link{{ $selectedCategory == $category->id ? ' active' : '' }}"
                                    href="javascript:void(0);">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button wire:click="loadDoctors" wire:loading.remove onclick="nextStep()"
                class="btn btn-primary">Next</button>
            <button class="btn btn-secondary" wire:click="prevStep" onclick="prevStep()">Previous</button>

        </div>

        <!-- خطوة 2 -->
        <div wire:loading.remove class="tab-pane fade @if ($currentStep == 2) show active @endif"
            id="step2">
            <!-- محتوى الخطوة 2 -->
            <h3>Choose Doctor</h3>
            <!-- Display doctors based on selection -->
            @if (!empty($doctors))
                <ul>
                    @foreach ($doctors as $doctor)
                        <li>{{ $doctor->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>No doctors available for the selected category.</p>
            @endif
            <button class="btn btn-secondary" wire:click="prevStep">Previous</button>
        </div>
    </div>
    <!-- Step 2 to Step 6 content goes here -->
    <div class="tab-pane fade" id="step6">
        <h3>Step 6: Review and Confirm</h3>
        <!-- Add a summary of the reservation here -->
        <button class="btn btn-primary" onclick="submitForm()">Confirm Reservation</button>
        <button class="btn btn-secondary" onclick="prevTab('tab5')">Previous</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
