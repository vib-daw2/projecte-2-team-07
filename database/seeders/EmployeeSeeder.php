<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $minConcessionaireId = DB::table('concessionaires')->min('id');
        $maxConcessionaireId = DB::table('concessionaires')->max('id');
        $departments = ['Asistencia técnica','Ventas','Finanzas','Marketing','Atención al Cliente'];
        for($i=$minConcessionaireId; $i<=$maxConcessionaireId;$i++){
            foreach ($departments as $department) {
                Employee::factory()
                ->times(2)
                ->create(['concessionaire_id' => $i,
                    'department' => $department,
                    'charge' => EmployeeSeeder::generateCharge($department)]);
            }
        }
    }
    private function generateCharge($department) {
        $charges = ['Asesor','Operador','Gerente','Técnico'];

        switch ($department) {
            case 'Asistencia técnica':
                return $charges[rand(2,3)];
                break;
            default:
            return $charges[rand(0,2)];
                break;
        }
    }
}
