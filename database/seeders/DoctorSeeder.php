<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorsData = [
            [
                'name' => ['en' => 'Dr. Munira Al-Randi', 'ar' => 'د.منيرة الرندي'],
                'start_date' => '2023-01-01',
                'start_time' => '08:00 AM',
                'national_id' => '123456789',
                'phone_number' => '123456789',
                'password' => Hash::make('password'),
                'categories_id' => 6, // Replace with the appropriate category ID
            ],
            [
                'name' => ['en' => 'Dr. Hessa Al-Aweirdi', 'ar' => 'د.حصه العويرضي'],
                'start_date' => '2023-01-02',
                'start_time' => '08:00 AM',
                'national_id' => '987654323',
                'phone_number' => '987654323',
                'password' => Hash::make('password'),
                'categories_id' => 12,
            ],

            [
                'name' => ['en' => 'Dr. Nashmiya Abdel Rahman', 'ar' => 'د.نشميه عبدالرحمن'],
                'start_date' => '2023-01-02',
                'start_time' => '08:00 AM',
                'national_id' => '987654322',
                'phone_number' => '987222222',
                'password' => Hash::make('password'),
                'categories_id' => 3,
            ],
            [
                'name' => ['en' => 'Dr. Maryam Al-Azmi', 'ar' => 'د.مريم العازمي'],
                'start_date' => '2023-01-02',
                'start_time' => '08:00 AM',
                'national_id' => '987654321',
                'phone_number' => '987654321',
                'password' => Hash::make('password'),
                'categories_id' => 9,
            ],
            [
                'name' => ['en' => 'Dr.Aisha Al-Sahli', 'ar' => 'عايشه السهلي'],
                'start_date' => '2023-01-02',
                'start_time' => '08:00 AM',
                'national_id' => '987654341',
                'phone_number' => '987654341',
                'password' => Hash::make('password'),
                'categories_id' => 4, // Replace with the appropriate category ID
            ],
        ];

        foreach ($doctorsData as $doctorData) {
            Doctor::create($doctorData);
        }
    }
}
