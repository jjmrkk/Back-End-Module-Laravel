<?php

use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('warehouses')->insert([
            //'id' => 1,
            'name' => 'Office Supplies',
            'description' => 'Office Supplies',
            'code' => 'OS',
            'business_unit_id' => 13,
            'user_id' => 1
        ]);

        DB::table('warehouses')->insert([
            //'id' => 2,
            'name' => 'Office Equipment',
            'description' => 'Office Equipment',
            'code' => 'OE',
            'business_unit_id' => 13,
            'user_id' => 1
        ]);

        DB::table('warehouses')->insert([
            //'id' => 3,
            'name' => 'Office Furniture',
            'description' => 'Office Furniture',
            'code' => 'OF',
            'business_unit_id' => 13,
            'user_id' => 1
        ]);
    }
}
