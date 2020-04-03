<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAndApplicationTypeToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('comment');
            $table->enum('user_type',['cod','dean','registrar','default'])->default('default');
            $table->unsignedInteger('app_id')->nullable();
            $table->enum('app_type',['incoming','outgoing','default'])->default('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('user_type');
            $table->dropColumn('app_id');
            $table->dropColumn('app_type');
        });
    }
}
