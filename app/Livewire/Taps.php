<?php

namespace App\Livewire;

use App\Models\Categories;
use App\Models\Doctor;
use Livewire\Component;


class Taps extends Component
{
    public $categories;
    public $doctors;
    public $selectedCategory;
    public $currentStep = 1;



    public function render()
    {
        $progressPercentage = ($this->currentStep - 1) / 5 * 100; // حيث أن 5 هو إجمالي عدد الخطوات

        $this->categories = Categories::all();

        return view('livewire.taps', [

            'progressPercentage' => $progressPercentage,
        ]);
    }

    public function loadDoctors()
    {
        $this->validate([
            'selectedCategory' => 'required|exists:categories,id',
        ]);

        $existsInCategories = Categories::where('id', $this->selectedCategory)->exists();

        if ($existsInCategories) {
            $this->doctors = Doctor::where('categories_id', $this->selectedCategory)->get();
            $this->currentStep++;
        } else {
            $this->addError('selectedCategory', 'You must select the section to move to the next step');
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadDoctors();
    }
}
