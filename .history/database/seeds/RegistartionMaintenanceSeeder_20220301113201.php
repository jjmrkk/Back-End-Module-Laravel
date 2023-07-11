<?php

use Illuminate\Database\Seeder;

class RegistartionMaintenanceSeeder extends Seeder
{

    public function run()
    {
        //Client_Type
        DB::table('registration_maintenance')->insert([
            'name' => 'Member',
            'description' => 'Member',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Dependent',
            'description' => 'Dependent',
            'category_id' => 1,
            'active' => true,
            'user_id' => null,
        ]);


        //Membership Category
        DB::table('registration_maintenance')->insert([
            'name' => 'Employed',
            'description' => 'Employed',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Indigent',
            'description' => 'Indigent',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Sponsored',
            'description' => 'Sponsored',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Lifetime',
            'description' => 'Lifetime',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Senior Citizen',
            'description' => 'Senior Citizen',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Informal',
            'description' => 'Informal',
            'category_id' => 2,
            'active' => true,
            'user_id' => null,
        ]);

    }
}
