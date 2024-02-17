<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make("meshal6616");
        User::query()->create([
            'name' => "مشعل الهندي",
            'email' => "meshal95@eng.com",
            "password" => "$password",
        ]);
    }
}
