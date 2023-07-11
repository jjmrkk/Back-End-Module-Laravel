<?php

use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{

  
    
    public function run()
    {

        $aaa = array(["date" => "2021-07-08", "reason" => "Reason 2", "hospital" => "Hospital 2"], ["date" => "2021-03-09", "reason" => "reason 1", "hospital" => "Hospital 1"]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '010523260109',
            'client_type_id' => 1,
            'membership_category_id' => 5,
            'last_name' => 'Flores',
            'first_name' => 'Joermark Anthony',
            'middle_name' => 'Catriz',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'M',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => '89587565',
            'registration_no' => 'BT-778955',
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '015326025963',
            'client_type_id' => 2,
            'membership_category_id' => 6,
            'last_name' => 'de Claro',
            'first_name' => 'Lois Lane',
            'middle_name' => 'Asebuche',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'F',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => '89587565',
            'registration_no' => 'BT-778955',
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '016357982536',
            'client_type_id' => 1,
            'membership_category_id' => 5,
            'last_name' => 'Perez',
            'first_name' => 'Renz Paul',
            'middle_name' => 'Cruz',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'f',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => '89587565',
            'registration_no' => 'BT-778955',
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '015326025963',
            'client_type_id' => 2,
            'membership_category_id' => 6,
            'last_name' => 'Comia',
            'first_name' => 'Joshua Richven',
            'middle_name' => 'Niebez',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'M',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => null,
            'registration_no' => 'BT-778955',
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '016325597523',
            'client_type_id' => 1,
            'membership_category_id' => 5,
            'last_name' => 'Cruz',
            'first_name' => 'Ruzbill Oliver',
            'middle_name' => '',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'M',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => null,
            'registration_no' => null,
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '015326025963',
            'client_type_id' => 2,
            'membership_category_id' => 6,
            'last_name' => 'Ramos',
            'first_name' => 'Elaine',
            'middle_name' => 'Panganiban',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'F',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => 'LY-65464574',
            'registration_no' => null,
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '01036872541',
            'client_type_id' => 1,
            'membership_category_id' => 5,
            'last_name' => 'Martija',
            'first_name' => 'Gio uzmin',
            'middle_name' => 'Castillo',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'M',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => null,
            'registration_no' => null,
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);

        DB::table('registration')->insert([
            //1
            'philhealth_id' => '017005689541',
            'client_type_id' => 2,
            'membership_category_id' => 6,
            'last_name' => 'Dalangin',
            'first_name' => 'Jhon Dave',
            'middle_name' => 'Familara',
            'extension' => null,
            'date_of_birth' => '1997-11-29',
            'gender' => 'F',
            'email' => 'email@yahoo.com',
            'contact_number' => '09350495385',
            'home_address' => 'Manigbas St, Bolo Bauan Batangas',
            'previous_illnesses' => json_encode([]),
            'hospitalization' => json_encode($aaa),
            'family_history_father' => json_encode(["15", "16", "20"]),
            'family_history_mother' => json_encode(["23", "24"]),
            'lifestyle_info' => json_encode(["27"]),
            'present_illnesses' => json_encode(["32","33"]),
            'immunization_history' => json_encode(["39"]),
            'maintenance_medication' => 'Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources.',
            'note' => 'Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. ',
            'atc_no' => null,
            'registration_no' => null,
            'user_id' => '11',
            'created_at' => '2022-03-09 13:52:31',
            'updated_at' => '2022-03-09 13:52:31'
        ]);
    }
}
