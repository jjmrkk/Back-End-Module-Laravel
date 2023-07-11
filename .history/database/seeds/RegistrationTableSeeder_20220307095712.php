<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            //1
            'email' => 'admin@sunwest.ph',
            'password' => Hash::make('admin123'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //2
            'email' => 'requestor1@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //3
            'email' => 'requestor2@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //4
            'email' => 'requestor3@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //5
            'email' => 'supervisor1@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //6
            'email' => 'supervisor2@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //7
            'email' => 'head1@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //8
            'email' => 'head2@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //9
            'email' => 'custodian1@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);

        DB::table('users')->insert([
            //10
            'email' => 'custodian2@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);
        DB::table('users')->insert([
            //11
            'email' => 'developer@sunwest.ph',
            'password' => Hash::make('12345678'),
            'active' => true
        ]);
    }
}
