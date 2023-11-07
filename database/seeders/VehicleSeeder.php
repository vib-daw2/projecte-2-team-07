<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\CustomerFactory; 
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $minConcessionaireId = DB::table('concessionaires')->min('id');
        $maxConcessionaireId = DB::table('concessionaires')->max('id');
        $models = ['Crossover','Sedan','Sport','Coupe'];

        foreach ($models as $model) {
            $num = 4;
            if($model == 'Sport'){
                $num = 6;
            }

            while ($num>0){
                $name = CustomerFactory::generateName('vehicle_names');
                $fuel = VehicleSeeder::generateFuel($model);
                $price = VehicleSeeder::generatePrice($model);
                $motor = CustomerFactory::generateName('motors');
                $year = VehicleSeeder::generateYear();

                for($i=$minConcessionaireId; $i<=$maxConcessionaireId;$i++){
                    Vehicle::factory()
                    ->create(['name' => 'Hydra '.$name,
                        'model' => $model,
                        'fuel' => $fuel,
                        'price' => $price,
                        'motor' => $motor,
                        'production_year' => $year,
                        'picture' => $model.''.$num.'.png',
                        'concessionaire_id' => $i
                        ]);
                }
                $num--;
            }   
        }
    }

    function generateFuel($model) {
        $fuels = ['Gasolina', 'Diésel', 'Hibrido', 'Eléctrico'];

         switch ($model) {
             case 'Sport':
                 $fuel = "Gasolina";
                 break;
             
             default:
                 $fuel = $fuels[array_rand($fuels)];
                 break;
         }          
        
         return $fuel;
     }

     function generatePrice($model) {
        $precio = mt_rand(14000, 50000);

         switch ($model) {
             case 'Sport':
                 $precio = mt_rand(90, 200).'000';
                 break;
             
             default:
                 $precio = mt_rand(20, 70).'000';
                 break;
         }          
        
         return $precio;
     }

     function generateYear() {    
        $year = rand(2015, 2023);
        $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
    
        return "$year-$month-$day";
     }
}
