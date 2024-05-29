<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Daywork;
use App\Models\Doctor;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use PDF;

class DashbordController extends Controller
{
    public function TimeView()
    {
        $id = auth()->user()->id;
        $data = Daywork::where('doctor_id', '=', $id)->first();

        $days = [];

        $daysMap = [
            'day1' => __('Sunday'),
            'day2' => __('Monday'),
            'day3' => __('Tuesday'),
            'day4' => __('Wednesday'),
            'day5' => __('Thursday'),
            'day6' => __('Friday'),
            'day7' => __('Saturday'),
        ];

        foreach ($daysMap as $key => $value) {
            if ($data->$key == 1) {
                $days[$key] = $value;
            }
        }

        return response()->view('doctor.time', ['data' => $days, "id" => $data->id, "time" => $data->time]);
    }

    public function timehour($day)
    {
        $id = auth()->user()->id;
        $Times = Time::where('doctor_id', $id)
            // ->where('daywork_id', $value)
            ->where('day', $day)
            ->get();
        $time = Daywork::where('doctor_id', '=', $id)->first()->time;

        return response()->view('doctor.timehour', ['day' => $day, 'data' => $Times, 'add' => $time]);
    }


    public function Duration(Request $request, $id)
    {
        $doctor = Daywork::where('doctor_id', '=', $id)->first();


        $validator = Validator($request->all(), [
            'duration' => 'required|numeric',
        ]);

        if (!$validator->fails()) {
            $doctor->time = $request->get('duration');
            $isSavedDay = $doctor->save();
            return response()->json([
                'message' => $isSavedDay ? __('Doctor\'s work duration has been updated successfully') : __("Failed to update doctor's work duration, please contact technical support"),
            ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function timehours(Request $request, $day)
    {
        $id = Auth::id();
        $time = new Time();
        $daywork = Daywork::where('doctor_id', '=', $id)->first();

        $validator = Validator($request->all(), [
            'timePicker' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);


        // التحقق الإضافي للحقول الوصف
        $validator->after(function ($validator) use ($request) {
            $descriptionAr = $request->input('description_ar');
            $descriptionEn = $request->input('description_en');

            // إذا كان أحد المدخلات غير فارغ، نتحقق من أن كلا المدخلين موجودين
            if ((!empty($descriptionAr) && empty($descriptionEn)) || (empty($descriptionAr) && !empty($descriptionEn))) {
                return response()->json([
                    'message' => __('The description must be entered in both Arabic and English')
                ], Response::HTTP_BAD_REQUEST);
            }
        });


        if (!$validator->fails()) {
            $inputTime = $request->get('timePicker');
            // Check if the session already exists for the given day, doctor, and time
            $existingSession = Time::where('doctor_id', $id)
                ->where('daywork_id', $daywork->id)
                ->where('day', $day)
                ->where('time', $inputTime)
                ->first();

            if ($existingSession) {
                return response()->json([
                    'message' => __('Cannot add the same session twice for the same day.')
                ], Response::HTTP_BAD_REQUEST);
            }

            // Check if the input time conflicts with existing session durations for the same day and doctor
            $inputTimeSeconds = strtotime($inputTime);

            // $conflictingSessions = Time::where('doctor_id', $id)
            //     ->where('day', $day)
            //     ->whereHas('daywork', function ($query) use ($inputTimeSeconds) {
            //         $query->where(function ($query) use ($inputTimeSeconds) {
            //             $query->whereRaw("UNIX_TIMESTAMP(`time`) <= ?", [$inputTimeSeconds])
            //                   ->whereRaw("UNIX_TIMESTAMP(TIME_ADD(`time`, INTERVAL `dayworks`.`time` MINUTE)) > ?", [$inputTimeSeconds]);
            //         })
            //         ->orWhere(function ($query) use ($inputTimeSeconds) {
            //             $query->whereRaw("UNIX_TIMESTAMP(`time`) > ?", [$inputTimeSeconds])
            //                   ->whereRaw("UNIX_TIMESTAMP(TIME_SUB(`time`, INTERVAL `dayworks`.`time` MINUTE)) < ?", [$inputTimeSeconds]);
            //         });
            //     })
            //     ->exists();


            //             if ($conflictingSessions) {
            //                 return response()->json([
            //                     'message' => __('A session cannot be added because it conflicts with an existing session.')
            //                 ], Response::HTTP_BAD_REQUEST);
            //             }

            // Save the session
            $time->time = $inputTime;
            $time->description =
                [
                    'en' => $request->get('description_en'),
                    'ar' => $request->get('description_ar'),
                ];
            $time->day = $day;
            $time->doctor_id = $id;
            $time->daywork_id = $daywork->id;
            $isSavedDay = $time->save();

            return response()->json([
                'message' => $isSavedDay ? __('The session was assigned for today successfully') : __("An error occurred, please contact technical support"),
            ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //VALIDATION FAILED`
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }



    public function booking()
    {
        $data = Booking::where('doctor_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->view('doctor.booking', ['data' => $data]);
    }


    public function invoice($id)
    {
        $data = Booking::where('id', $id)->with('Categories')->with('Time')->first();

        return response()->view('doctor.invoice', ['data' => $data]);
    }


    public function downloadInvoice($id)
    {
        $data = Booking::where('id', $id)->with('Categories')->with('Time')->first();
        $pdf = PDF::loadView('doctor.invoice2', compact('data'));
        // return $pdf->stream('document.pdf');
        return $pdf->download("document_$data->id.pdf");

        // $pdf = \PDF::loadView('doctor.invoice', compact('data'));
        // return $pdf->download('invoice.pdf');
    }
}
