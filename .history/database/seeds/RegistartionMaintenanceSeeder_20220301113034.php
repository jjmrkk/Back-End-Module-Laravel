<?php

use Illuminate\Database\Seeder;

class RegistartionMaintenanceSeeder extends Seeder
{

    public function run()
    {

        //Membership Category
        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Employed',
            'description' => 'Employed',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Indigent',
            'description' => 'Indigent',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Sponsored',
            'description' => 'Sponsored',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Lifetime',
            'description' => 'Lifetime',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Senior Citizen',
            'description' => 'Senior Citizen',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            'name' => 'Informal',
            'description' => 'Informal',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

    }
}
