<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('item_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_code', 100);
            $table->string('name', 100);
            $table->bigInteger('item_category_details_id');
            $table->longText('description')->nullable();
            $table->bigInteger('item_brand_id');
            $table->bigInteger('item_model_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('item_location_id');
            $table->float('minimum', 8, 2);
            $table->float('maximum', 8, 2);
            $table->longText('minimum_msg')->nullable();
            $table->longText('maximum_msg')->nullable();
            $table->longText('item_attributes')->nullable();
            $table->float('quantity', 8, 2)->default(0.00);
            $table->bigInteger('user_id');
            $table->timestamps();

            $table->index(['item_code', 'item_category_details_id', 'warehouse_id']);
            $table->foreign('item_category_details_id')->references('id')->on('item_category_details');
            $table->foreign('item_brand_id')->references('id')->on('item_brands');
            $table->foreign('item_model_id')->references('id')->on('item_models');
            $table->foreign('item_location_id')->references('id')->on('item_locations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_details');
    }
}
