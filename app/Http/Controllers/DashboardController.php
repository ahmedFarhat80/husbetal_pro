<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Daywork;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }



    public function index_Doctor()
    {
        $data = Doctor::with('Category')->get();
        $Category = Categories::get();

        // Example: Assume you want to preselect categories with IDs 1 and 2
        $selectedCategories = [];

        return response()->view('dashboard.doctor.index', compact('data', 'Category', 'selectedCategories'));
    }


    public function index_Doctor_Create(Request $request)
    {
        $validator = Validator($request->all(), [
            'name_ar' => 'required|string|min:3|max:100',
            'name_en' => 'required|string|min:3|max:100',
            "work_start_date" => "required|date",
            "start_time" => "required|date_format:h:i A",
            "national_id" => "required|numeric",
            "phone" => "required|numeric|digits:8",
            'select' => 'required|numeric',
            "day7" => 'in:0,1',
            "day1" => 'in:0,1',
            "day2" => 'in:0,1',
            "day3" => 'in:0,1',
            "day4" => 'in:0,1',
            "day5" => 'in:0,1',
            "day6" => 'in:0,1',

        ]);


        if (!$validator->fails()) {
            if (
                $request->get('day7') === null &&
                $request->get('day1') === null &&
                $request->get('day2') === null &&
                $request->get('day3') === null &&
                $request->get('day4') === null &&
                $request->get('day5') === null &&
                $request->get('day6') === null
            ) {
                return response()->json([
                    'message' => "يجب اختيار على الأقل يوم دوام واحد"
                ], Response::HTTP_BAD_REQUEST);
            }

            $Doctor = new Doctor();
            $Doctor->name =
                [
                    'en' => $request->get('name_en'),
                    'ar' => $request->get('name_ar'),
                ];
            $Doctor->national_id = $request->get('national_id');
            $Doctor->start_date = $request->get('work_start_date');
            $Doctor->start_time = $request->get('start_time');
            $Doctor->phone_number = $request->get('phone');
            $Doctor->categories_id = $request->get('select');
            $day = new Daywork();
            $isSavedDoctor =  $Doctor->save();
            if ($isSavedDoctor) {
                $day = new Daywork();
                $day->day7 = $request->filled('day7') ? 1 : 0;
                $day->day1 = $request->filled('day1') ? 1 : 0;
                $day->day2 = $request->filled('day2') ? 1 : 0;
                $day->day3 = $request->filled('day3') ? 1 : 0;
                $day->day4 = $request->filled('day4') ? 1 : 0;
                $day->day5 = $request->filled('day5') ? 1 : 0;
                $day->day6 = $request->filled('day6') ? 1 : 0;
                $day->doctor_id = $Doctor->id;
                // تعيين doctor_id بعد حفظ الطبيب
                $isSavedDay = $day->save(); // حفظ الأيام والتحقق مما إذا تم بنجاح

                return response()->json([
                    'message' => $isSavedDay ? "تم اضافة الطبيب بنجاح" : "فشلت عملية اضافة الطبيب",
                ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'message' => "فشلت عملية اضافة الطبيب"
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }



    public function index_Section()
    {
        $data = Categories::get();
        return response()->view('dashboard.Section.index', compact('data'));
    }

    public function getSectionById($id)
    {
        $section = Categories::find($id);

        if (!$section) {
            return response()->json(['error' => 'Section not found'], 404);
        }
        // Get the translated values for each translatable attribute
        $translatedNameAr = $section->getTranslation('name', 'ar');
        $translatedNameEn = $section->getTranslation('name', 'en');

        // Return the section data, including translated values
        return response()->json([
            'id' => $section->id,
            'name_ar' => $translatedNameAr,
            'name_en' => $translatedNameEn,
        ]);
    }

    public function addSection(Request $request)
    {
        $validator = Validator($request->all(), [
            'name_ar' => 'required|min:2',
            'name_en' => 'required|min:2',
        ]);

        if (!$validator->fails()) {

            $Categories = new  Categories();
            $Categories->name =
                [
                    'en' => $request->get('name_en'),
                    'ar' => $request->get('name_ar'),
                ];


            $Categories->save();
            return response()->json([
                'message' =>  __('The section has been added successfully'),
                'section' => $Categories,
            ], Response::HTTP_CREATED);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateSection(Request $request, $id)
    {
        $validator = Validator($request->all(), [
            'name_ar' => 'required|min:2',
            'name_en' => 'required|min:2',
        ]);

        if (!$validator->fails()) {

            $Categories =  Categories::find($id);
            $Categories->name =
                [
                    'en' => $request->get('name_en'),
                    'ar' => $request->get('name_ar'),
                ];
            $Categories->save();
            return response()->json([
                'message' =>  __('The section has been updated successfully'),
                'section' => $Categories,
            ], Response::HTTP_CREATED);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy_Section($id)
    {
        $category = Categories::find($id);
        $isDeleted = $category->delete();
        if ($isDeleted) {
            return response()->json(['icon' => 'success', 'title' => __('Success!'), 'text' => __('Deleted successfully')], Response::HTTP_OK);
        } else {
            return response()->json(['icon' => 'error', 'title' =>  __('Failed!'), 'text' => __('Delete failed')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index_Admin()
    {
        $data = User::get();
        return response()->view('dashboard.Admin.index', compact('data'));
    }
}
