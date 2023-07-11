<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_request_header_id', 11); //foreign & index
            $table->bigInteger('item_request_id'); //foreign & index
            $table->bigInteger('item_id'); //foreign & index
            $table->float('quantity', 8, 2);
            $table->bigInteger('custodian_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('item_request_header_id')->references('id')->on('item_request_headers');
            $table->foreign('item_request_id')->references('id')->on('item_requests');
            //$table->foreign('item_id')->references('id')->on('items');
            //$table->index(['item_request_header_id', 'item_request_id', 'item_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_request_details');
    }
}
