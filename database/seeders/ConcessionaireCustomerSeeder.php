<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConcessionaireCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minCustomerId = DB::table('customers')->min('id');
        $maxCustomerId = DB::table('customers')->max('id');
        $minConcessionaireId = DB::table('concessionaires')->min('id');
        $maxConcessionaireId = DB::table('concessionaires')->max('id');

        for($i=$minCustomerId; $i<=$maxCustomerId;$i++){
            $correspondingConcessionaires = rand(1, 3);

            $concessionaires = array();
            for($j=$minConcessionaireId; $j<=$maxConcessionaireId;$j++){
                array_push($concessionaires, $j);
            }

            for($k=1; $k<=$correspondingConcessionaires;$k++){
                $rand_concessionaire = array_rand($concessionaires);
                unset($concessionaires[$rand_concessionaire]);
                $rand_concessionaire++;
                DB::table('concessionaire_customer')->insert([
                    'concessionaire_id' => $rand_concessionaire,
                    'customer_id' => $i       
                ]);
            }
        }
    }
}
