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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('doctorid');
            $table->date('dateofappt');
            $table->time('timestart');
            $table->time('timeend');
            $table->text('remarks')->nullable();
            $table->integer('status')->default('0')->comment('0=active,1=inactive,2=cancel');
            $table->text('specializationID')->nullable();
            $table->integer('noofpatients')->default('0');
            $table->integer('isOne')->nullable()->comment('1 : true');
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
        Schema::dropIfExists('schedules');
    }
};
