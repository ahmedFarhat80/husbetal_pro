<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Daywork;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ControllController extends Controller
{
    public function dateSelct()
    {
        $userData = session('user_data');
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        $doctor = Doctor::where('id', '=', $userData['doctor'])->first()->name;
        $Dayworks = Daywork::where('doctor_id', '=', $userData['doctor'])->get();
        $disabledDates = ["2023-12-03"]; // افتراضي - قم بتحديثها بناءً على احتياجاتك

        return response()->view('frontend.date', ['Category' => $Category, 'doctor' => $doctor, 'Dayworks' => $Dayworks, 'disabledDates' => $disabledDates]);
    }
}
