<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Daywork;
use App\Models\Doctor;
use App\Models\Time;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\DayOfWeek;
use App\Models\Booking;
use App\Models\Complaint;
use Carbon\Carbon;


class ControllController extends Controller
{
    public function dateSelct()
    {
        $userData = session('user_data');
        if (empty($userData['doctor'])) {
            return redirect('/doctor');
        }
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        $doctor = Doctor::where('id', '=', $userData['doctor'])->first()->name;
        $Dayworks = Daywork::where('doctor_id', '=', $userData['doctor'])->get();

        // جلب عدد الجلسات في اليوم للطبيب
        //  جلب عدد الحجوزات لكل االجلسات المحجوزة في اليوم مع تطابق التواريخ اا تساوووت اغلق التاريخ



        // $Tims = Time::where('doctor_id', $userData['doctor'])->get();

        $disabledDates = $this->getSessionsCountForRepeatedDates($userData);
        $formattedDisabledDates = array_map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        }, $disabledDates);

        // dd($formattedDisabledDates);
        // dd($disabledDates);

        $disabledDates = $formattedDisabledDates;
        // $disabledDates = ["2024-05-20", "2024-05-22"];
        return response()->view('frontend.date', ['Category' => $Category, 'doctor' => $doctor, 'Dayworks' => $Dayworks, 'disabledDates' => $disabledDates]);
    }

    public function dateSelct_ok(Request $request)
    {
        $validator = Validator($request->all(), [
            'datepicker' => 'required',
        ]);
        if (!$validator->fails()) {

            $userData = session('user_data');

            $newData = [
                'Section' => $userData['Section'],
                'doctor' => $userData['doctor'],
                'date' => $request->get('datepicker'),
                'time' => '',
            ];
            session(['user_data' => $newData]);
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

    public function TimeSelct()
    {
        $userData = session('user_data');
        if (empty($userData['date'])) {
            return redirect('/date');
        }
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        $doctor = Doctor::where('id', '=', $userData['doctor'])->first()->name;
        $add = Daywork::where('doctor_id', '=', $userData['doctor'])->first()->time;

        $timestamp = strtotime($userData['date']);
        $dayOfWeek = strtoupper(date('l', $timestamp));
        $day = constant("App\Enums\DayOfWeek::$dayOfWeek");

        // $Booking = Booking::where('date', $userData['date'])->get();
        // $Tims = Time::where('doctor_id', $userData['doctor'])->where('id', '!=', $Booking->time_id)->where('day', $day)->get();

        $bookings = Booking::where('date', $userData['date'])
            ->where('doctor_id', $userData['doctor'])
            ->pluck('time_id')
            ->toArray();

        $Tims = Time::where('doctor_id', $userData['doctor'])
            ->whereNotIn('id', $bookings)
            ->where('day', $day)
            ->get();

        // dd($Tims);
        return response()->view('frontend.time', ['add' => $add, 'Category' => $Category, 'doctor' => $doctor,  'day' => date('l', $timestamp), 'date' => $userData['date'], 'Tims' => $Tims]);
    }


    public function time(Request $request)
    {
        $validator = Validator($request->all(), [
            'time' => 'required',
        ]);
        if (!$validator->fails()) {

            $userData = session('user_data');

            $newData = [
                'Section' => $userData['Section'],
                'doctor' => $userData['doctor'],
                'date' => $userData['date'],
                'time' =>  $request->get('time'),
            ];
            session(['user_data' => $newData]);


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


    public function data_info()
    {
        $userData = session('user_data');
        if (empty($userData['time'])) {
            return redirect('/time');
        }
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        $doctor = Doctor::where('id', '=', $userData['doctor'])->first()->name;
        $Tims = Time::where('id', $userData['time'])->first();
        return response()->view('frontend.data_info', ['Category' => $Category, 'doctor' => $doctor, 'date' => $userData['date'], 'Tims' => $Tims]);
    }


    public function data_info_store(Request $request)
    {
        $validator = Validator($request->all(), [
            'firstName' => 'required|string|max:255',
            'middleName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|digits:8',
            'idNumber' => 'required|string|max:255',
            'idType' => 'required|string|max:255',
            'day' => 'nullable|numeric|digits_between:1,2',
            'month' => 'nullable|numeric|digits_between:1,2',
            'year' => 'nullable|numeric|digits:4',
        ]);
        if (!$validator->fails()) {
            $userData = session('user_data');
            $newData = [
                'Section' => $userData['Section'],
                'doctor' => $userData['doctor'],
                'date' => $userData['date'],
                'time' =>  $userData['time'],
                'firstName' => $request->get('firstName'),
                'middleName' => $request->get('middleName'),
                'lastName' => $request->get('lastName'),
                'phoneNumber' => $request->get('phoneNumber'),
                'idNumber' => $request->get('idNumber'),
                'idType' => $request->get('idType'),
                'day' => $request->get('day'),
                'month' => $request->get('month'),
                'year' => $request->get('year'),
            ];
            session(['user_data' => $newData]);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function booking_summary()
    {
        $userData = session('user_data');
        // dd($userData);
        if (empty($userData['firstName'])) {
            return redirect('/data_info');
        }
        $Category = Categories::where('id', '=', $userData['Section'])->first()->name;
        $doctor = Doctor::where('id', '=', $userData['doctor'])->first()->name;
        $Tims = Time::where('id', $userData['time'])->first()->time;
        return response()->view('frontend.booking-summary', ['Category' => $Category, 'doctor' => $doctor, 'time' => $Tims]);
    }

    public function booking_summary_store()
    {
        $userData = session('user_data');

        $booking = new Booking();
        $booking->date = $userData['date'];
        $booking->first_name = $userData['firstName'];
        $booking->middle_name = $userData['middleName'];
        $booking->last_name = $userData['lastName'];
        $booking->phone_number = $userData['phoneNumber'];
        $booking->id_number = $userData['idNumber'];
        $booking->id_type  = $userData['idType'];
        $booking->day = $userData['day'];
        $booking->month = $userData['month'];
        $booking->year = $userData['year'];
        $booking->time_id = $userData['time'];
        $booking->section_id = $userData['Section'];
        $booking->doctor_id = $userData['doctor'];
        $isSaved = $booking->save();

        $randomNumber = $booking->id;

        return response()->json([
            'message' => $isSaved ? __('Your reservation has been successfully saved') : __('An error occurred, please contact technical support'),
            'rand' => $randomNumber
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function booking_success(Request $request, $id)
    {
        $data = Booking::findOrFail($id);

        $request->session()->forget('user_data');


        return response()->view('frontend.booking-success', ['id' => $id]);
    }





    public function getSessionsCountForRepeatedDates($userData)
    {
        // جلب عدد الجلسات لكل يوم للطبيب المحدد
        $sessionsCountPerDay = Time::select('day', \DB::raw('COUNT(*) as sessions_count'))
            ->where('doctor_id', $userData['doctor'])
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        // جلب كل الحجوزات التابعة للطبيب المحدد
        $bookings = Booking::where('doctor_id', $userData['doctor'])->get();

        // تحديد التواريخ المتكررة وحساب عدد الجلسات المحجوزة لكل تاريخ
        $repeatedDates = $bookings->groupBy('date')->map(function ($group) {
            return $group->count();
        });

        // لكل تاريخ مكرر، العودة إلى جدول الجلسات (times) لمعرفة اليوم وعدد الجلسات في ذلك اليوم
        $daysSessions = [];
        $repeatedDates->each(function ($count, $date) use (&$daysSessions, $userData) {
            $timeIds = Booking::where('date', $date)
                ->where('doctor_id', $userData['doctor'])
                ->pluck('time_id');

            $sessions = Time::whereIn('id', $timeIds)
                ->select('day', \DB::raw('COUNT(*) as session_count'))
                ->groupBy('day')
                ->get();

            $daysSessions[$date] = $sessions;
        });

        // مصفوفة التواريخ التي يجب تعطيلها
        $disabledDates = [];

        // مقارنة عدد الجلسات المحجوزة مع عدد الجلسات المحدد لكل يوم
        foreach ($daysSessions as $date => $sessions) {
            foreach ($sessions as $session) {
                if (
                    isset($sessionsCountPerDay[$session->day]) &&
                    $session->session_count >= $sessionsCountPerDay[$session->day]->sessions_count
                ) {
                    $disabledDates[] = $date;
                    break; // إذا كان هناك يوم تم حجزه بالكامل، يتم إضافته وتعطيل الباقي
                }
            }
        }

        return $disabledDates;
    }



    public function Complaints()
    {
        $Sections = Categories::all();
        $currentLang = app()->getLocale(); // الحصول على اللغة الحالية للنظام

        return response()->view('frontend.Complaints', ['sections' => $Sections, $currentLang]);
    }

    public function fetchDoctors(Request $request)
    {
        $doctors = Doctor::where('categories_id', $request->department_id)->get();
        return response()->json(['doctors' => $doctors]);
    }

    public function Complaints_done(Request $request)
    {

        $validator = Validator($request->all(), [
            'complaint_type'               => 'required|string',
            'name'                         => 'required|string|min:10|max:255',
            'phoneNumber'                  => 'required|string|digits:8',
            'idNumber'                     => 'required|numeric',
            'doctor_complaint_description' => 'required|string',
            'doctor'                       => 'nullable|',
            'department'                   => 'nullable|',
        ]);

        // dd($request->get('complaint_type'));

        if (!$validator->fails()) {
            $Complaint = new Complaint();
            $Complaint->complaint_type  = $request->get('complaint_type');
            $Complaint->user_name       = $request->get('name');
            $Complaint->phone_number    = $request->get('phoneNumber');
            $Complaint->id_number       = $request->get('idNumber');
            $Complaint->description     = $request->get('doctor_complaint_description');
            $Complaint->categories_id   = $request->get('department');
            $Complaint->doctor_id       = $request->get('doctor');
            $isSaved = $Complaint->save();
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => $isSaved ? __('Your complaint has been sent successfully. We will contact you within the shortest possible time') : __('Got a problem try it later'),
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }
}
