<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AppointmentForm extends Component
{
    public $selectedDepartment;
    public $selectedDoctor;
    public $selectedDate;
    public $selectedTime;

    // قم بتعبئة هذه المتغيرات بالبيانات من قاعدة البيانات
    public $departments = ['قسم الأطفال', 'قسم النساء', 'قسم العظام'];
    public $doctors = [];
    public $availableDates = [];
    public $availableTimes = [];

    public function updatedSelectedDepartment($value)
    {
        // قم بتحديث قائمة الأطباء بناءً على القسم المحدد
        // $this->doctors = ...

        // إعادة تعيين باقي الحقول
        $this->selectedDoctor = null;
        $this->selectedDate = null;
        $this->selectedTime = null;
    }

    public function updatedSelectedDoctor($value)
    {
        // قم بتحديث تواريخ الحجز بناءً على الطبيب المحدد
        // $this->availableDates = ...

        // إعادة تعيين باقي الحقول
        $this->selectedDate = null;
        $this->selectedTime = null;
    }

    public function updatedSelectedDate($value)
    {
        // قم بتحديث أوقات الحجز بناءً على التاريخ المحدد
        // $this->availableTimes = ...

        // إعادة تعيين باقي الحقول
        $this->selectedTime = null;
    }

    public function render()
    {
        return view('livewire.Taps');
    }
}
