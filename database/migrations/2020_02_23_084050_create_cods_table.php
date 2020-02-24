<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cods', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedInteger('department_id');
            $table->string('email')->unique()->nullable();
            $table->string('name')->nullable();
            //$table->foreign('department_id')->references('dep_id')->on('departments')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('cods');
    }
}
