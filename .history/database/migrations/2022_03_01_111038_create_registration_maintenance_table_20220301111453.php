<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationMaintenanceTable extends Migration
{

    public function up()
    {
        Schema::create('registration_maintenance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('description');
            $table->bigInteger('category_id');
            $table->boolean('active')->default('true');
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registration_maintenance');
    }
}
