<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = session('user_data');
        if (empty($userData['Section'])) {
            return redirect('/');
        }
        $doctors = Doctor::where('categories_id', '=', $userData['Section'])->get();
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        return response()->view('frontend.doctor_selct', ['doctors' => $doctors, 'Category' => $Category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'categoryId' => 'required|exists:categories,id',
        ]);


        if (!$validator->fails()) {
            // عند فتح الموقع، قم بتخزين المصفوفة في الجلسة إذا لم تكن موجودة بالفعل
            if (!session()->has('user_data')) {
                // إنشاء مصفوفة من 6 عناصر لكل شخص
                $initialData = [
                    'Section' => $request->get('categoryId'),
                    'doctor' => '',
                    'date' => '',
                    'time' => '',
                ];
                // تخزين المصفوفة في الجلسة
                session(['user_data' => $initialData]);

                $userData = session('user_data');

                return response()->json([
                    'message' =>  __('The section is selected and we move to the second step'),
                ], Response::HTTP_CREATED);
            } else {
                $userData = session('user_data');
                $newData = [
                    'Section' => $request->get('categoryId'),
                    'doctor' => '',
                    'date' => '',
                    'time' => '',
                ];
                session(['user_data' => $newData]);
                return response()->json([
                    'message' =>  __('The section is selected and we move to the second step'),
                ], Response::HTTP_CREATED);
            }
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator($request->all(), [
            'doctoId' => 'required|exists:doctors,id',
        ]);


        if (!$validator->fails()) {

            $userData = session('user_data');

            $newData = [
                'Section' => $userData['Section'],
                'doctor' => $request->get('doctoId'),
                'date' => '',
                'time' => '',
            ];
            session(['user_data' => $newData]);
            // dd($newData);
            return response()->json([
                'message' =>  __('The section is selected and we move to the second step'),
            ], Response::HTTP_CREATED);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
