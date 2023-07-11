<?php

use Illuminate\Database\Seeder;

class ItemRequestStatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('item_request_status')->insert([
            'id' => 1,
            'name' => 'For Approval',
            'description' => 'For Approval'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 2,
            'name' => 'Disapproved',
            'description' => 'Disapproved'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 3,
            'name' => 'Approved',
            'description' => 'Approved'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 4,
            'name' => 'Processing',
            'description' => 'Processing'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 5,
            'name' => 'Cancelled By Custodian',
            'description' => 'Cancelled By Custodian'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 6,
            'name' => 'For Puchase',
            'description' => 'For Puchase'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 7,
            'name' => 'Partially Delivered',
            'description' => 'Partially Delivered'
        ]);

        DB::table('item_request_status')->insert([
            'id' => 8,
            'name' => 'Delivered',
            'description' => 'Delivered'
        ]);  
    }
}
