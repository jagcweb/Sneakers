<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class category_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            \DB::table('categories')->insert(array(
                'name' => 'Categoria ' . $i
            ));
        }

        $this->command->info('La tabla se ha rellenado');
    }
}
