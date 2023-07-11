<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_request_header_id', 11); //foreign & index
            $table->longText('description');
            $table->float('quantity', 8, 2);
            $table->bigInteger('unit_of_measure_id');
            $table->date('date_needed'); //index
            $table->float('status_id', 8, 2); //index
            $table->boolean('urgent')->default(false); //index
            $table->json('file_path')->nullable();
            $table->bigInteger('item_details_id')->nullable();
            $table->timestamps();

            $table->foreign('item_request_header_id')->references('id')->on('item_request_headers');
            $table->foreign('unit_of_measure_id')->references('id')->on('unit_of_measures');
            $table->index(['item_request_header_id', 'status_id', 'date_needed', 'urgent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_requests');
    }
}
