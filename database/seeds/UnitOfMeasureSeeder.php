<?php

use Illuminate\Database\Seeder;

class UnitOfMeasureSeeder extends Seeder
{
    public function run()
    {
        DB::table('unit_of_measures')->insert([
            'name' => 'Piece/s',
            'abbr' => 'Pc/s',
            'user_id' => 1,
        ]);

        DB::table('unit_of_measures')->insert([
            'name' => 'Liter/s',
            'abbr' => 'Ltr/s',
            'user_id' => 1,
        ]);

        DB::table('unit_of_measures')->insert([
            'name' => 'Ream/s',
            'abbr' => 'Ream/s',
            'user_id' => 1,
        ]);

        DB::table('unit_of_measures')->insert([
            'name' => 'Gallon/s',
            'abbr' => 'Gal/s',
            'user_id' => 1,
        ]);

        DB::table('unit_of_measures')->insert([
            'name' => 'Drum/s',
            'abbr' => 'Drum/s',
            'user_id' => 1,
        ]);

        DB::table('unit_of_measures')->insert([
            'name' => 'Dozen/s',
            'abbr' => 'Dz/s',
            'user_id' => 1,
        ]);
    }
}
