<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCategoryDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('item_category_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('business_unit_id');
            $table->string('code', 50);
            $table->string('name', 100);
            $table->longText('description')->nullable();
            $table->boolean('tag')->default('true');
            $table->jsonb('attribute_id');
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('warehouse_id');
            $table->timestamps();

            $table->index(['business_unit_id']);
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('unit_id')->references('id')->on('unit_of_measures');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_category_details');
    }
}
