<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Concessionaire;

class ConcessionaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $concessionaires = [
            [                
                'name'  => 'Hydra Center BCN SUD',
                'phone_number' => 931222583,
                'email' => 'ventas@catalunyawagen.hydra.es',
                'address' => 'Pol. Ind Zona Franca, C/ A, 61, 08040, Barcelona, Barcelona',
                'coordinates' => '2.1403913832109445, 41.33689605054748',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Motorsol Import',
                'phone_number' => 931222622,
                'email' => 'ventas@motorsol.hydra.es',
                'address' => 'Ctra. Del Prat, 3, 08830, Sant Boi De Llobregat, Barcelona',
                'coordinates' => '2.0468090385970794, 41.33544383183661',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Sarsa Valles',
                'phone_number' => 931222633,
                'email' => 'Fcuenca@sarsa.com',
                'address' => 'Carrer Jiloca 8, 08223, Terrassa, Barcelona',
                'coordinates' => '2.038020338608017, 41.547991249256235',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Servisimó',
                'phone_number' => 931222634,
                'email' => 'ventas@servisimo.hydra.es',
                'address' => 'C/ Alemanya, 17, 08700, Igualada, Barcelona',
                'coordinates' => '1.6254165809381844, 41.58887143480121',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Superwagen',
                'phone_number' => 931222635,
                'email' => 'ventas@superwagen.hydra.es',
                'address' => 'Ctra. de Rubí 62-64, 08174, Sant Cugat, Barcelona',
                'coordinates' => '2.0624760116202747, 41.48016980496114',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Vilamòbil',
                'phone_number' => 931222636,
                'email' => 'ventas@vilamobil.hydra.es',
                'address' => 'Ronda Europa, 68, 08800, Vilanova i la Geltrú, Barcelona',
                'coordinates' => '1.7361747250996866, 41.233057672194306',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [                
                'name'  => 'Mogauto',
                'phone_number' => 931222617,
                'email' => 'ventas@mogauto.hydra.es',
                'address' => 'Paseo Guayaquil 5, 8030, Barcelona, Barcelona',
                'coordinates' => '2.2074767809305578, 41.44056549892688',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Concessionaire::insert($concessionaires);
    }
}
