@props(['tableId', 'columns'])

@section('CSS')
    <style>
        /* لتخصيص عناصر التحكم في DataTables */
        /* تحسين تصميم عناصر التحكم في DataTables */
        .dataTables_length,
        .dataTables_filter {
            margin: 18px !important;
            /* زيادة المسافة بين عناصر التحكم */
        }

        .dataTables_length label,
        .dataTables_filter label {
            font-weight: normal;
            /* إلغاء تحديد الخط الغامق لتسهيل القراءة */
        }

        .dataTables_length select,
        .dataTables_filter input {
            border-radius: 5px;
            /* إضافة زوايا دائرية لعناصر التحكم */
        }

        /* تحسين تصميم حقول البحث */
        .dataTables_filter input {
            padding: 5px;
            /* تحديد التباعد داخل حقل البحث */
            width: 100%;
            /* تحديد عرض حقل البحث ليمتد بشكل كامل */
        }

        /* تحسين تصميم العناصر داخل الريسبونسيف */
        @media (max-width: 767px) {

            .dataTables_length,
            .dataTables_filter {
                margin-bottom: 15px;
                /* زيادة المسافة بين عناصر التحكم في وضع الريسبونسيف */
            }

            .dataTables_length select,
            .dataTables_filter input {
                width: 100%;
                /* تحديد عرض عناصر التحكم في وضع الريسبونسيف ليمتد بشكل كامل */
            }
        }

        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;


        }


        /* تحسين شكل الجدول */
        #example {
            width: 100%;
            margin-top: 20px;
            /* تضاف المسافة بين الجدول والعناصر السابقة */
            border-collapse: collapse;
            /* إلغاء تقسيم الحدود بين الخلايا */
        }

        #example th,
        #example td {

            padding: 12px;
            text-align: center;
        }

        #example thead th {
            background-color: #343a40;
            /* لون الهيدر */
            color: #ffffff;
            /* لون النص في الهيدر */
        }

        #example tbody tr:nth-child(even) {
            background-color: #f8f9fa;
            /* لون الصفوف الزوجية */
        }

        #example tbody tr:hover {
            background-color: #e9ecef;
            /* لون الصفوف عند التحويم */
        }

        /* تحسين الخلايا في حال تم استخدام اللغة العربية */
        #example td {
            font-family: 'cairo';
            /* اختيار الخط الملائم للنص العربي */
        }

        /* تحسين تصميم حقول البحث وعدد العناصر المعروضة */
        .dataTables_length select,
        .dataTables_filter input {
            border-radius: 5px;
            margin-bottom: 10px;
        }

        /* تحسين تصميم البيانات في وضع الريسبونسيف */
        @media (max-width: 767px) {
            #example thead {
                display: none;
                /* إخفاء الهيدر عند العرض الصغير */
            }

            #example tbody td {
                display: block;
                text-align: right;
                /* محاذاة النص إلى اليمين في حال استخدام اللغة العربية */
            }
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            margin: 18px !important;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding: 18px !important;
            padding-top: 25px !important;
        }

        /* تعديلات للمظهر */
        .text-gray-800 {
            margin-right: 20px;
            /* تزيين المسافة بين النص والزر */
        }

        .btn-primary {
            margin-left: 10px;
            padding: 10px 20px;
            /* زيادة التباعد داخل الزر */
        }

        .fa-plus {
            font-size: 18px;
            margin-bottom: 2px;
            /* ضبط الموقع الرأسي للأيقونة */
        }

        /* لتحسين توسيع الزر عند التحويس عليه */
        .btn-primary:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

<table id="{{ $tableId }}" class="table table-hover table-bordered"
    @if (app()->getLocale() == 'ar') style="direction: rtl" @endif>
    <thead class="table-dark">
        <tr>
            @foreach ($columns as $column)
                <th class="px-4 py-2.5 text-center">{{ __("$column") }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
