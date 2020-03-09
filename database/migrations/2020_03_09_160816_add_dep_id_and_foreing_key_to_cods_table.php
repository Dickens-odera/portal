<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepIdAndForeingKeyToCodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cods', function (Blueprint $table) {
            $table->unsignedBigInteger('dep_id')->nullable();
            $table->foreign('dep_id')->references('dep_id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cods', function (Blueprint $table) {
            $table->dropForeign('dep_id');
        });
    }
}
