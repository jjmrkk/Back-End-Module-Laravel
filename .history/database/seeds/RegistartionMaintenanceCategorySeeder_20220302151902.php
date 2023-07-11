<?php

use Illuminate\Database\Seeder;

class RegistartionMaintenanceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registration_maintenance_categories')->insert([
            //'id' => 1,
            'name' => 'Client_Type',
            'description' => 'Client_Type',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 2,
            'name' => 'Membership_Category',
            'description' => 'Membership_Category',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 3,
            'name' => 'Previous_Illnesses',
            'description' => 'Previous_Illnesses',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 3,
            'name' => 'Client_Type',
            'description' => 'Client_Type',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 4,
            'name' => 'Family_History',
            'description' => 'Mother Side',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 5,
            'name' => 'Addiction',
            'description' => 'Addiction',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 6,
            'name' => 'Present_Illnesses',
            'description' => 'Present_Illnesses',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 7,
            'name' => 'Immunization_History',
            'description' => 'Immunization_History',
            'user_id' => null,
        ]);

        DB::table('registration_maintenance_categories')->insert([
            //'id' => 9,
            'name' => 'Family_History',
            'description' => 'Father Side',
            'user_id' => null,
        ]);

    }
}
