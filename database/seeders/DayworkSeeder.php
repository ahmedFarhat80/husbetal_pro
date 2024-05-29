<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DayworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dayworkData = [
            'day7' => 0,
            'day1' => 0,
            'day2' => 0,
            'day3' => 0,
            'day4' => 0,
            'day5' => 0,
            'day6' => 0,
        ];

        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            $doctor->day()->create($dayworkData);
        }
    }
}
