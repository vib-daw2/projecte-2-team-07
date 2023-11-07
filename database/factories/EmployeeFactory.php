<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = CustomerFactory::generateName('names').' '.CustomerFactory::generateName('names');
        return [
            //
            'name'  => $name.' '.CustomerFactory::generateName('last_names'),
            'phone_number' => CustomerFactory::generatePhoneNumber("6"),
            'email' => CustomerFactory::generateEmail($name),
            'address' => CustomerFactory::generateName('random_addresses'),
            'dni' => EmployeeFactory::generateDNI(),      
        ];
    }
    public static function generateDNI() {
        $number = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        $letter = chr(rand(65, 90)); // Letra aleatoria mayúscula (A-Z)
        return $number . $letter;
    }
}
