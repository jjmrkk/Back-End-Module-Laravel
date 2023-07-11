<?php

use Illuminate\Database\Seeder;

class ItemRequestBusinessUnitsTableSeeder extends Seeder
{
    public function run()
    {
        //SCDC - MANILA
        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 16,
            'description' => json_encode([16])
        ]);

        //SUWECO - MANILA
        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 48,
            'description' => json_encode([48, 56, 57])
        ]);

        //SUWECO 2 - MANILA
        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 49,
            'description' => json_encode([49, 62])
        ]);

        //SUWECO TABLAS
        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 50,
            'description' => json_encode([50, 64])
        ]);
        
        //SUWECO-SORECO
        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 51,
            'description' => json_encode([51, 58])
        ]);

        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 52,
            'description' => json_encode([52])
        ]);

        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 53,
            'description' => json_encode([53])
        ]);

        DB::table('item_request_business_units')->insert([
            'business_unit_id' => 54,
            'description' => json_encode([54])
        ]);
    }
}
