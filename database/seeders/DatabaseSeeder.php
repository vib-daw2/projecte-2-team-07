<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Concessionaire;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
        	ConcessionaireSeeder::class,
        	EmployeeSeeder::class,
            VehicleSeeder::class,
            CustomerSeeder::class,
            ConcessionaireCustomerSeeder::class,
            UserSeeder::class,
         ]);
    }
}
