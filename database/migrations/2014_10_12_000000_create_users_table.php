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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('proxy')->comment('0-false,1-true')->nullable();
            $table->text('proxyName')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('contactno');
            $table->string('license')->nullable();
            $table->string('user_type')->comment('admin=admin,doctor=doctor,patient=patient');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('specialization')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->integer('fl');
            $table->integer('otp');
            $table->string('designation')->nullable();
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
        Schema::dropIfExists('users');
    }
};
