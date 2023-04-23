<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('apptID')->default('0');
            $table->text('category');
            $table->integer('doctor');
            $table->date('dateofappointment')->nullable();
            $table->time('timeofappointment')->nullable();
            $table->integer('status')->comments('0=pending,1=approved,2=cancelled,3=disapproved,4=completed,5=referred');
            $table->integer('ad_status');
            $table->integer('refferedto');
            $table->integer('refferedto_doctor');
            $table->text('remarks');
            $table->text('purpose');
            $table->text('diagnostics');
            $table->text('treatment');
            $table->text('attachedfile')->nullable();
            $table->integer('laps');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
