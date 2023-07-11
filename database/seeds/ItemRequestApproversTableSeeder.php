<?php

use Illuminate\Database\Seeder;

class ItemRequestApproversTableSeeder extends Seeder
{
    public function run()
    {
        //ACCOUNTING
        DB::table('item_request_approvers')->insert([
            'business_unit_id' => 17,
            'group_id' => 41,
            'first' => json_encode([5]),
            'second' => json_encode([7]),
        ]);

        DB::table('item_request_approvers')->insert([
            'business_unit_id' => 17,
            'group_id' => 42,
            'first' => json_encode([6]),
            'second' => json_encode([7]),
        ]);

        //INFORMATION TECHNOLOGY
        DB::table('item_request_approvers')->insert([
            'business_unit_id' => 28,
            'group_id' => null,
            'first' => json_encode([]),
            'second' => json_encode([8]),
        ]);

        //COST CONTROL/INVENTORY
        DB::table('item_request_approvers')->insert([
            'business_unit_id' => 31,
            'group_id' => null,
            'first' => json_encode([]),
            'second' => json_encode([]),
        ]);
    }
}
