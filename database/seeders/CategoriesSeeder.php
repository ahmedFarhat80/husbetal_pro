<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            'Department of Ophthalmology' => [
                'en' => 'Department of Ophthalmology',
                'ar' => 'قسم العيون'
            ],
            'Chronic Diseases Clinic' => [
                'en' => 'Chronic Diseases Clinic',
                'ar' => 'عيادة الأمراض المزمنة'
            ],
            'Department of Dermatology' => [
                'en' => 'Department of Dermatology',
                'ar' => 'قسم الجلدية'
            ],
            'Department of Physical Medicine' => [
                'en' => 'Department of Physical Medicine',
                'ar' => 'قسم الطب الطبيعي'
            ],
            'Department of General Surgery' => [
                'en' => 'Department of General Surgery',
                'ar' => 'قسم الجراحة العامة'
            ],
            'Department of Urology' => [
                'en' => 'Department of Urology',
                'ar' => 'قسم جراحة المسالك البولية'
            ],
            'Department of Nutrition' => [
                'en' => 'Department of Nutrition',
                'ar' => 'قسم التغذية'
            ],
            'Pediatric Optometry' => [
                'en' => 'Pediatric Optometry',
                'ar' => 'بصريات الأطفال'
            ],
            'Orthopedic Department' => [
                'en' => 'Orthopedic Department',
                'ar' => 'قسم جراحة العظام'
            ],
            'Cosmetic and Burns Department' => [
                'en' => 'Cosmetic and Burns Department',
                'ar' => 'قسم التجميل والحروق'
            ],
            'Spine' => [
                'en' => 'Spine',
                'ar' => 'العامود الفقري'
            ],
            'Ear, Nose, Throat and Ear Department' => [
                'en' => 'Ear, Nose, Throat and Ear Department',
                'ar' => 'قسم الأذن والأنف والحنجرة'
            ],
            'Rheumatology Department' => [
                'en' => 'Rheumatology Department',
                'ar' => 'قسم الروماتيزم'
            ],
        ];

        foreach ($categoriesData as $englishName => $translations) {
            $category = new Categories();
            $category->setTranslation('name', 'en', $englishName);
            $category->setTranslation('name', 'ar', $translations['ar']);
            $category->save();
        }
    }
}
