<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->text('description');
            $table->string('code', 10)->nullable();
            $table->boolean('active')->default('true');
            $table->bigInteger('business_unit_id');
            $table->bigInteger('user_id');
            $table->timestamps();

            $table->index(['business_unit_id']);
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
