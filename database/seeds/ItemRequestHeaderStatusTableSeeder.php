<?php

use Illuminate\Database\Seeder;

class ItemRequestHeaderStatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('item_request_header_status')->insert([
            'id' => 1,
            'name' => 'Return To Requestor',
            'description' => 'Return To Requestor'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 2,
            'name' => 'Cancelled By Requestor',
            'description' => 'Cancelled By Requestor'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 3,
            'name' => 'On Queue For Immediate Supervisor Approval',
            'description' => 'On Queue For Immediate Supervisor Approval'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 4,
            'name' => 'Acknowledged By Immediate Supervisor',
            'description' => 'Acknowledged By Immediate Supervisor'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 5,
            'name' => 'Disapproved By Immediate Supervisor',
            'description' => 'Disapproved By Immediate Supervisor'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 6,
            'name' => 'On Queue For Department Head Approval',
            'description' => 'On Queue For Department Head Approval'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 7,
            'name' => 'Acknowledged By Department Head',
            'description' => 'Acknowledged By Department Head'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 8,
            'name' => 'Disapproved By Department Head',
            'description' => 'Disapproved By Department Head'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 9,
            'name' => 'On Custodian Queue',
            'description' => 'Disapproved Department Head Approval'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 10,
            'name' => 'Acknowledged By Custodian',
            'description' => 'Acknowledged By Custodian'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 11,
            'name' => 'Cancelled By Custodian',
            'description' => 'Cancelled By Custodian'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 12,
            'name' => 'Partially Delivered',
            'description' => 'Partially Delivered'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 13,
            'name' => 'Delivered',
            'description' => 'Delivered'
        ]);

        DB::table('item_request_header_status')->insert([
            'id' => 14,
            'name' => 'For Purchase Request',
            'description' => 'For Purchase Request'
        ]);
    }
}
