<?php

use Illuminate\Database\Seeder;

class ProjectUserRolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('project_user_roles')->insert([
            'name' => 'Project Manager',
            'code' => 'Project Manager',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Project Supervisor',
            'code' => 'Project Supervisor',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Project Engineer',
            'code' => 'Project Engineer',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Site Engineer',
            'code' => 'Site Engineer',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Contruction Foreman',
            'code' => 'Contruction Foreman',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Equipment Checker',
            'code' => 'Equipment Checker',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Time Keeper',
            'code' => 'Time Keeper',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Warehouse Man',
            'code' => 'Warehouse Man',
            'description' => 'NONE',
        ]);

        DB::table('project_user_roles')->insert([
            'name' => 'Utility Man',
            'code' => 'Utility Man',
            'description' => 'NONE',
        ]);
    }
}
