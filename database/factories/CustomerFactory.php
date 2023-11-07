<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = CustomerFactory::generateName('names').' '.CustomerFactory::generateName('last_names');
        return [
            //
            'name'  => $name.' '.CustomerFactory::generateName('last_names'),
            'phone_number' => CustomerFactory::generatePhoneNumber("6"),
            'email' => CustomerFactory::generateEmail($name),
            'address' => CustomerFactory::generateName('random_addresses'),
        ];
    }

    public static function generateName($names): string
    {
        $json_path = base_path('database/data/'.$names.'.json');
        $json_data = file_get_contents($json_path);
        $array_names = json_decode($json_data, true);

        if ($array_names === null) {
            die("Error al decodificar el JSON.");
        }

        // Verificar si existe un registro de names seleccionados
        $selected_names = isset($_SESSION[$names]) ? $_SESSION['selected_'.$names] : [];

        // Obtener una lista de names que no se han seleccionado aún
        $selected_names = array_diff($array_names[$names], $selected_names);

        // Si se han seleccionado todos los nombres, reiniciar la lista
        if (empty($selected_names)) {
            $selected_names = [];
            $selected_names = $array_names[$names];
        }

        $random_name = array_rand($selected_names);
        $selected_names[] = $selected_names[$random_name];
        $_SESSION['selected_'.$names] = $selected_names;

        return $selected_names[$random_name];
    }

    public static function generatePhoneNumber($number) {
        for ($i = 1; $i <= 8; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }

    public static function generateEmail($name) {
        $domain = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        
        $random_domain = $domain[array_rand($domain)];
        $name = str_replace(' ', '.', $name);
        $name = deleteAccents($name);
        $name = mb_strtolower($name);
        $email = $name.'@'.$random_domain;
        
        return $email;
    }
}

function deleteAccents($string){
		
    //Reemplazamos la A y a
    $string = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $string
    );

    //Reemplazamos la E y e
    $string = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $string );

    //Reemplazamos la I y i
    $string = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $string );

    //Reemplazamos la O y o
    $string = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $string );

    //Reemplazamos la U y u
    $string = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $string );

    //Reemplazamos la N, n, C y c
    $string = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $string
    );
    
    return $string;
}
