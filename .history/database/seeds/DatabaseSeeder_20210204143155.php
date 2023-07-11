<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BusinessUnitTypesTableSeeder::class);
        $this->call(BusinessUnitsTableSeeder::class);
        $this->call(BusinessUnitRelationsTableSeeder::class);
        $this->call(ItemRequestBusinessUnitsTableSeeder::class);
        $this->call(ItemRequestApproversTableSeeder::class);
        $this->call(BusinessUnitPositionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserProfilesTableSeeder::class);
        $this->call(UserAccessTableSeeder::class);
        $this->call(ProjectUserRolesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
        $this->call(UnitOfMeasureSeeder::class);
        $this->call(ItemRequestHeaderStatusTableSeeder::class);
        $this->call(ItemRequestStatusTableSeeder::class);
    }
}
