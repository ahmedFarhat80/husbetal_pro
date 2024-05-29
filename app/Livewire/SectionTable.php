<?php

namespace App\Livewire;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class SectionTable extends Component
{
    public $data;
    public $name_ar;
    public $validatedData;
    public $name_en;

    public function render()
    {
        $this->data = Categories::orderBy('created_at', 'desc')->get();

        return view('livewire.section-table', ['data' => $this->data]);
    }

    public function addSection()
    {
        $validatedData =  $this->validate([
            'name_ar' => 'required|min:2',
            'name_en' => 'required|min:2',
        ]);

        $categories = new Categories();
        $categories->name = [
            'en' => $this->name_en,
            'ar' => $this->name_ar,
        ];

        $categories->save();
    }


}
