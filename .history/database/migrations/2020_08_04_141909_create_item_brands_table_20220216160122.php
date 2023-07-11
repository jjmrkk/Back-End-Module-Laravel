<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBrandsTable extends Migration
{
    public function up()
    {
        Schema::create('item_brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_unit_id');
            $table->string('name', 50);
            $table->bigInteger('user_id');
            $table->bigInteger('warehouse_id');
            $table->timestamps();

            $table->index(['business_unit_id']);
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_brands');
    }
}
