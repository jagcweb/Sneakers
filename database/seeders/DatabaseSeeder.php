<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
 \DB::table('regions')->insert([
            ['id' => '1', 'state_id' => 8, 'region_name' => 'Albacete'],
            ['id' => '2', 'state_id' => 8, 'region_name' => 'Ciudad Real'],
            ['id' => '3', 'state_id' => 8, 'region_name' => 'Cuenca'],
            ['id' => '4', 'state_id' => 8, 'region_name' => 'Guadalajara'],
            ['id' => '5', 'state_id' => 8, 'region_name' => 'Toledo'],
            ['id' => '6', 'state_id' => 2, 'region_name' => 'Huesca'],
            ['id' => '7', 'state_id' => 2, 'region_name' => 'Teruel'],
            ['id' => '8', 'state_id' => 2, 'region_name' => 'Zaragoza'],
            ['id' => '9', 'state_id' => 18, 'region_name' => 'Ceuta'],
            ['id' => '10', 'state_id' => 13, 'region_name' => 'Madrid'],
            ['id' => '11', 'state_id' => 14, 'region_name' => 'Murcia'],
            ['id' => '12', 'state_id' => 19, 'region_name' => 'Melilla'],
            ['id' => '13', 'state_id' => 15, 'region_name' => 'Navarra'],
            ['id' => '14', 'state_id' => 1, 'region_name' => 'Almería'],
            ['id' => '15', 'state_id' => 1, 'region_name' => 'Cádiz'],
            ['id' => '16', 'state_id' => 1, 'region_name' => 'Córdoba'],
            ['id' => '17', 'state_id' => 1, 'region_name' => 'Granada'],
            ['id' => '18', 'state_id' => 1, 'region_name' => 'Huelva'],
            ['id' => '19', 'state_id' => 1, 'region_name' => 'Jaén'],
            ['id' => '20', 'state_id' => 1, 'region_name' => 'Málaga'],
            ['id' => '21', 'state_id' => 1, 'region_name' => 'Sevilla'],
            ['id' => '22', 'state_id' => 3, 'region_name' => 'Asturias'],
            ['id' => '23', 'state_id' => 6, 'region_name' => 'Cantabria'],
            ['id' => '24', 'state_id' => 7, 'region_name' => 'Ávila'],
            ['id' => '25', 'state_id' => 7, 'region_name' => 'Burgos'],
            ['id' => '26', 'state_id' => 7, 'region_name' => 'León'],
            ['id' => '27', 'state_id' => 7, 'region_name' => 'Palencia'],
            ['id' => '28', 'state_id' => 7, 'region_name' => 'Salamanca'],
            ['id' => '29', 'state_id' => 7, 'region_name' => 'Segovia'],
            ['id' => '30', 'state_id' => 7, 'region_name' => 'Soria'],
            ['id' => '31', 'state_id' => 7, 'region_name' => 'Valladolid'],
            ['id' => '32', 'state_id' => 7, 'region_name' => 'Zamora'],
            ['id' => '33',  'state_id' => 9, 'region_name' => 'Barcelona'],
            ['id' => '34',  'state_id' => 9, 'region_name' => 'Gerona'],
            ['id' => '35',  'state_id' => 9, 'region_name' => 'Lérida'],
            ['id' => '36',  'state_id' => 9, 'region_name' => 'Tarragona'],
            ['id' => '37',  'state_id' => 11, 'region_name' => 'Badajoz'],
            ['id' => '38',  'state_id' => 11, 'region_name' => 'Cáceres'],
            ['id' => '39',  'state_id' => 12, 'region_name' => 'Coruña, La'],
            ['id' => '40',  'state_id' => 12, 'region_name' => 'Lugo'],
            ['id' => '41',  'state_id' => 12, 'region_name' => 'Orense'],
            ['id' => '42',  'state_id' => 12, 'region_name' => 'Pontevedra'],
            ['id' => '43',  'state_id' => 17, 'region_name' => 'Rioja, La'],
            ['id' => '44',  'state_id' => 4, 'region_name' => 'Baleares, Islas'],
            ['id' => '45',  'state_id' => 16, 'region_name' => 'Álava'],
            ['id' => '46',  'state_id' => 16, 'region_name' => 'Guipúzcoa'],
            ['id' => '47',  'state_id' => 16, 'region_name' => 'Vizcaya'],
            ['id' => '48',  'state_id' => 5, 'region_name' => 'Palmas, Las'],
            ['id' => '49',  'state_id' => 5, 'region_name' => 'Tenerife, Santa Cruz De'],
            ['id' => '50',  'state_id' => 10, 'region_name' => 'Alicante'],
            ['id' => '51',  'state_id' => 10, 'region_name' => 'Castellón'],
            ['id' => '52',  'state_id' => 10, 'region_name' => 'Valencia']
        ]);
    }
}
