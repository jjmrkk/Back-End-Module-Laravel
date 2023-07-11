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

         //Previos Illness
         DB::table('registration_maintenance')->insert([
            'name' => 'Measles (Tigdas)',
            'description' => 'Measles (Tigdas)',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);

         DB::table('registration_maintenance')->insert([
            'name' => 'Pheumatic Fever',
            'description' => 'Pheumatic Fever',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Mumps (Beke)',
            'description' => 'Mumps (Beke)',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);


        DB::table('registration_maintenance')->insert([
            'name' => 'Polio',
            'description' => 'Polio',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);


        DB::table('registration_maintenance')->insert([
            'name' => 'Rubella (Tigdas)',
            'description' => 'Rubella (Tigdas)',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);


        DB::table('registration_maintenance')->insert([
            'name' => 'Chicken Pox',
            'description' => 'Chicken Pox',
            'category_id' => 3,
            'active' => true,
            'user_id' => null,
        ]);

        //Family History
        DB::table('registration_maintenance')->insert([
            'name' => 'High Blood Pressure',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'High Cholesterol',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Heart Disease',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Stroke',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Gastrointestinal Disorder',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Diabetes',
            'description' => 'Mother Side',
            'category_id' => 4,
            'active' => true,
            'user_id' => null,
        ]);

        //Addiction
        DB::table('registration_maintenance')->insert([
            'name' => 'Smoking',
            'description' => 'Smoking',
            'category_id' => 5,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Alcohol',
            'description' => 'Alcohol',
            'category_id' => 5,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Illicit Drugs',
            'description' => 'Illicit Drugs',
            'category_id' => 5,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Sexual Activity',
            'description' => 'Sexual Activity',
            'category_id' => 5,
            'active' => true,
            'user_id' => null,
        ]);

        //Present Illnesses
        DB::table('registration_maintenance')->insert([
            'name' => 'Hypertension',
            'description' => 'Hypertension',
            'category_id' => 6,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Diabetic Mellitus',
            'description' => 'Diabetic Mellitus',
            'category_id' => 6,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Asthma',
            'description' => 'Asthma',
            'category_id' => 6,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'PTB (Pulmnary Tuberculosis)',
            'description' => 'PTB (Pulmnary Tuberculosis)',
            'category_id' => 6,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Goiter',
            'description' => 'Goiter',
            'category_id' => 6,
            'active' => true,
            'user_id' => null,
        ]);

        //Immunization History
        DB::table('registration_maintenance')->insert([
            'name' => 'Diptheria Telanus',
            'description' => 'Diptheria Telanus',
            'category_id' => 7,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Hepatitis',
            'description' => 'Hepatitis',
            'category_id' => 7,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Influenza',
            'description' => 'Influenza',
            'category_id' => 7,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Pineumococcal',
            'description' => 'Pineumococcal',
            'category_id' => 7,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Covid-19',
            'description' => 'Covid-19',
            'category_id' => 7,
            'active' => true,
            'user_id' => null,
        ]);

         //Family History father side
         DB::table('registration_maintenance')->insert([
            'name' => 'High Blood Pressure',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'High Cholesterol',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Heart Disease',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Stroke',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Gastrointestinal Disorder',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

        DB::table('registration_maintenance')->insert([
            'name' => 'Diabetes',
            'description' => 'Father Side',
            'category_id' => 9,
            'active' => true,
            'user_id' => null,
        ]);

    }
}
