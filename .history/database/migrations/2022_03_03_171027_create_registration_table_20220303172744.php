<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration
{

    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('philhealth_id');
            $table->bigInteger('client_type');
            $table->bigInteger('membership_category');
            $table->string('first_name', 254);
            $table->string('last_name', 254);
            $table->string('middle_name', 254)->nullable();
            $table->string('extension', 254)->nullable();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->jsonb('previous_illnesses')->nullable();
            $table->jsonb('hospitalization')->nullable();
            $table->jsonb('family_history')->nullable();
            $table->jsonb('addiction')->nullable();
            $table->jsonb('present_illnesses')->nullable();
            $table->jsonb('immunization_history')->nullable();
            $table->longText('maintenance_medication')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registration');
    }
}
