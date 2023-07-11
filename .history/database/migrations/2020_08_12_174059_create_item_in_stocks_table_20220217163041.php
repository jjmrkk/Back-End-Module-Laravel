<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInStocksTable extends Migration
{
    public function up()
    {
        Schema::create('item_in_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_detail_id');
            $table->bigInteger('unit_id');
            $table->float('quantity', 8, 2);
            $table->float('cost', 8, 2);
            $table->float('value', 8, 2);
            $table->float('balance', 8, 2);
            $table->text('location')->nullable();
            $table->bigInteger('user_id');
            $table->integer('status')->default(1);
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->timestamps();

            $table->index(['item_detail_id']);
            $table->foreign('item_detail_id')->references('id')->on('item_details');
            $table->foreign('unit_id')->references('id')->on('unit_of_measures');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_in_stocks');
    }
}
