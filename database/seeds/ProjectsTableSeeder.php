<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'Matnog Port Project',
            'code' => 'Matnog Port Project',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'Tabaco Project III',
            'code' => 'Tabaco Project III',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'Tabaco Project II',
            'code' => 'Tabaco Project II',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC 47 Units',
            'code' => 'NPC 47 Units',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC MARAMAG',
            'code' => 'NPC MARAMAG',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC MARAMAG 2',
            'code' => 'NPC MARAMAG 2',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC-11x300KW',
            'code' => 'NPC-11x300KW',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC-12x80KW',
            'code' => 'NPC-12x80KW',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC-3x160KW &32x80KW',
            'code' => 'NPC-3x160KW &32x80KW',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);

        DB::table('projects')->insert([
            'business_unit_id' => 13,
            'name' => 'NPC-5x1000KW',
            'code' => 'NPC-5x1000KW',
            'address' => 'NONE',
            'description' => 'NONE',
            'user_id' => 1
        ]);
    }
}
