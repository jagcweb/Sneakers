<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class product_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            \DB::table('products')->insert(array(
                'category_id' => 41+$i,
                'name' => 'Air Force ' . $i,
                'brand' => 'Nike '.$i,
                'price' => 5*$i,
                'created_at' => NULL,
                'updated_at' => NULL
            ));
        }

        $this->command->info('La tabla se ha rellenado');
    }
}
