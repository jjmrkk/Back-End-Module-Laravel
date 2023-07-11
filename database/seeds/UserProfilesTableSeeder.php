<?php

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_profiles')->insert([
            'user_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'contact_no' => '0',
            'employee_no' => '000000001',
            'business_unit_id' => 28,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 2,
            'first_name' => 'requestor1',
            'last_name' => 'requestor1',
            'contact_no' => '0',
            'employee_no' => '000000002',
            'business_unit_id' => 17,
            'group_id' => 41,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 3,
            'first_name' => 'requestor2',
            'last_name' => 'requestor2',
            'contact_no' => '0',
            'employee_no' => '000000003',
            'business_unit_id' => 17,
            'group_id' => 42,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 4,
            'first_name' => 'requestor3',
            'last_name' => 'requestor3',
            'contact_no' => '0',
            'employee_no' => '000000004',
            'business_unit_id' => 28,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 5,
            'first_name' => 'supervisor1',
            'last_name' => 'supervisor1',
            'contact_no' => '0',
            'employee_no' => '000000005',
            'business_unit_id' => 17,
            'group_id' => 41,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 6,
            'first_name' => 'supervisor2',
            'last_name' => 'supervisor2',
            'contact_no' => '0',
            'employee_no' => '000000006',
            'business_unit_id' => 17,
            'group_id' => 42,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 7,
            'first_name' => 'head1',
            'last_name' => 'head1',
            'contact_no' => '0',
            'employee_no' => '000000007',
            'business_unit_id' => 17,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 8,
            'first_name' => 'head2',
            'last_name' => 'head2',
            'contact_no' => '0',
            'employee_no' => '000000008',
            'business_unit_id' => 28,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 9,
            'first_name' => 'custodian1',
            'last_name' => 'custodian1',
            'contact_no' => '0',
            'employee_no' => '000000009',
            'business_unit_id' => 31,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 10,
            'first_name' => 'custodian2',
            'last_name' => 'custodian2',
            'contact_no' => '0',
            'employee_no' => '000000010',
            'business_unit_id' => 31,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 11,
            'first_name' => 'User Developer',
            'last_name' => '',
            'contact_no' => '0',
            'employee_no' => '000000011',
            'business_unit_id' => 31,
            'group_id' => null,
            'business_unit_position_id' => 1,
            'theme' => 'dark',
        ]);
    }
}
