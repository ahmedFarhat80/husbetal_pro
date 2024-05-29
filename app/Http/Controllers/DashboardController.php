<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Categories;
use App\Models\Complaint;
use App\Models\Daywork;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Spatie\Permission\Models\Role;
use ZipArchive;

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
            "national_id" => "required|numeric|unique:doctors,national_id",
            "phone" => "required|numeric|digits:8|unique:doctors,phone_number",
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
                    'message' => __("You must choose at least one working day")
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
                    'message' => $isSavedDay ? __("The doctor's information has been added successfully") :  __("The operation failed, please contact technical support"),
                ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'message' =>  __("The operation failed, please contact technical support"),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function Edit_Doctor($id)
    {
        $doctor = Doctor::with('day')->findOrFail($id);
        return response()->json([
            'doctor' => $doctor,
        ], Response::HTTP_CREATED);
    }

    public function update_Doctor(Request $request, $id)
    {

        $validator = Validator($request->all(), [
            'name_ar' => 'required|string|min:3|max:100',
            'name_en' => 'required|string|min:3|max:100',
            "work_start_date" => "required|date",
            "start_time" => "required|date_format:h:i A",
            "national_id" => "required|numeric|unique:doctors,national_id,{$id}",
            "phone" => "required|numeric|digits:8|unique:doctors,phone_number,{$id}",
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
                    'message' => __("You must choose at least one working day")
                ], Response::HTTP_BAD_REQUEST);
            }

            $Doctor = Doctor::findOrFail($id);

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
            $isSavedDoctor =  $Doctor->save();
            if ($isSavedDoctor) {
                $day = Daywork::where('doctor_id', '=', $id)->first();
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
                    'message' => $isSavedDay ? __('Doctor data has been updated successfully') : __("The operation failed, please contact technical support"),
                ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'message' => __("The operation failed, please contact technical support")
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function doctor_status(Request $request, $id)
    {
        $newStatus = $request->status;
        // استرجاع الطبيب من قاعدة البيانات
        if ($newStatus == "Inactive") {
            $newStatus = 0;
            $status = "active";
        } else {
            $newStatus = 1;
            $status = "Inactive";
        }
        $doctor = Doctor::findOrFail($id);

        // تحديث حالة الطبيب
        $doctor->isactive = $newStatus;
        $doctor->save();

        return response()->json(['status' => $status, 'message' => 'Doctor status updated successfully']);
    }



    public function doctor_delete($id)
    {
        try {
            // احصل على جميع اسماء الجداول في قاعدة البيانات
            $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

            // قم بتنفيذ عملية الحذف على كل جدول يحتوي على doctor_id
            foreach ($tables as $table) {
                if (Schema::hasColumn($table, 'doctor_id')) {
                    // حذف الصفوف التي تحتوي على doctor_id محددة في الجدول الحالي
                    DB::table($table)->where('doctor_id', $id)->delete();
                }
            }

            $Doctor = Doctor::find($id);
            $isDeleted = $Doctor->delete();

            return response()->json(['icon' => 'success', 'title' => __('Success!'), 'text' => __('Deleted successfully')], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['icon' => 'error', 'title' => __('Failed!'), 'text' => __('Delete failed')], Response::HTTP_BAD_REQUEST);
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
        try {
            $category = Categories::find($id);

            $doctors = $category->doctors;

            foreach ($doctors as $doctor) {
                $this->doctor_delete($doctor->id);
            }

            Complaint::where('categories_id', $id)->delete();

            $isDeleted = $category->delete();

            return response()->json(['icon' => 'success', 'title' => __('Success!'), 'text' => __('Deleted successfully')], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['icon' => 'error', 'title' => __('Failed!'), 'text' => __('Delete failed')], Response::HTTP_BAD_REQUEST);
        }
    }



    public function index_Admin()
    {
        $data = User::with('roles')->get();
        $roles = Role::all();
        return response()->view('dashboard.admin.index', compact('data', 'roles'));
    }


    public function Store_Admin(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name_ar' => 'required|string|min:3|max:30',
            'name_en' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $admin = new User();
            $admin->name =
                [
                    'en' => $request->get('name_en'),
                    'ar' => $request->get('name_ar'),
                ];
            $admin->email = $request->get('email');
            $admin->password = Hash::make($request->get('password'));
            $isSaved = $admin->save();



            return response()->json([
                'message' => $isSaved ? __('Saved successfully') : __('Failed to save')
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function Update_Admin(Request $request, $id)
    {
        $admin = User::find($id);
        $validator = Validator($request->all(), [
            'name_ar' => 'required|string|min:3|max:30',
            'name_en' => 'required|string|min:3|max:30',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($admin->id)],
            'password' => 'nullable|string|min:6', // نجعل كلمة المرور اختيارية
        ]);
        if (!$validator->fails()) {
            $admin->name =
                [
                    'en' => $request->get('name_en'),
                    'ar' => $request->get('name_ar'),
                ];
            $admin->email = $request->get('email');
            if ($request->get('password') != null) {
                $admin->password = Hash::make($request->get('password'));
            }
            $isSaved = $admin->save();
            return response()->json([
                'message' => $isSaved ? __('Saved successfully') : __('Failed to save')
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy_Admin($id)
    {
        $admin = User::find($id);
        $isDeleted = $admin->delete();
        if ($isDeleted) {
            return response()->json([
                'title' => __('Success!'), 'text' => __('Deleted successfully'), 'icon' => 'success'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'title' => __('Failed!'), 'text' => __('delete failed'), 'icon' => 'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function booking()
    {
        $data = Booking::all();
        return response()->view('dashboard.booking.index', ['data' => $data]);
    }

    public function deleteRows_booking(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'ids' => 'required|array', // Asegura que 'ids' sea un array
        ]);

        try {
            // Obtener los IDs de las filas a eliminar desde la solicitud
            $ids = $request->input('ids');

            Booking::destroy($ids);
            // Si llegamos aquí, la eliminación fue exitosa
            return response()->json(['message' => __('Rows deleted successfully')], 200);
        } catch (\Exception $e) {
            // En caso de un error, enviar una respuesta de error
            return response()->json(['message' => __('Failed to delete rows')], 500);
        }
    }



    public function PDF_Export(Request $request)
    {
        $selectedIds = $request->ids;

        // استخدم المعرّفات لاسترداد السجلات المرتبطة
        $bookings = Booking::whereIn('id', $selectedIds)->get();

        // إنشاء مصفوفة لتخزين مسارات ملفات PDF
        $pdfFiles = [];

        foreach ($bookings as $data) {
            $pdf = PDF::loadView('doctor.invoice2', compact('data'));

            // حفظ الملف PDF مؤقتاً
            $pdfFilename = 'invoice_' . $data->id . '.pdf';
            $pdfFilePath = storage_path('app/public/' . $pdfFilename);
            $pdf->save($pdfFilePath);

            // إضافة الملف الحالي إلى مصفوفة الملفات
            $pdfFiles[] = $pdfFilePath;
        }

        // إنشاء ملف مضغوط في الذاكرة
        $zip = new ZipArchive();
        $zipFilename = storage_path('app/public/invoices.zip');
        if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {
            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create ZIP file'], 500);
        }

        // إرجاع رابط تنزيل الملف المضغوط
        $zipUrl = Storage::url('invoices.zip');
        $response = response()->json(['zip_url' => $zipUrl]);

        // حذف ملفات PDF بعد الضغط
        foreach ($pdfFiles as $file) {
            unlink($file);
        }

        return $response;
    }




    public function Complaints()
    {
        $data = Complaint::all();
        return response()->view('dashboard.Complaints.index', ['data' => $data]);
    }

    public function Complaint_view($id)
    {
        $data = Complaint::with('Category')->findOrFail($id);
        return response()->view('dashboard.Complaints.view', ['data' => $data]);
    }

    public function Complaints_delete($id)
    {
        $Complaint = Complaint::findOrFail($id);

        $isDelete = $Complaint->delete();
        if ($isDelete) {
            return response()->json(
                ['title' => __('Success!'), 'text' => __('Complaint Deleted Successfully'), 'icon' => 'success'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['title' => __('Failed!'), 'text' => __('Complaint Deleted Failed'), 'icon' => 'error'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
