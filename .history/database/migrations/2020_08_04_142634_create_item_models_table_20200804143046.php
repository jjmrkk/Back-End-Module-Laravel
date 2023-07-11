<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemModelsTable extends Migration
{
    public function up()
    {
        Schema::create('item_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->bigInteger('item_brand_id');
            $table->string('item_code', 50);
            $table->jsonb('item_supplier_id');
            $table->bigInteger('user_id');
            $table->timestamps();

            $table->index(['item_brand_id']);
            $table->foreign('item_brand_id')->references('id')->on('item_brands');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_models');
    }
}
