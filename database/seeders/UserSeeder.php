<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name'  => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$qLPRVAnGCS7z8DY.1AsU2O8JnPMJbqaycZC21rGs5wF.iFkgQ8NZe', //admin123
                'permissions' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        User::insert($users);
    }
}
