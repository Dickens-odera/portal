<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('app_id');
            $table->string('student_name');
            $table->string('reg_number');
            $table->integer('student_phone');
            $table->integer('kcse_index');
            $table->year('kcse_year');
            $table->string('present_program');
            $table->string('present_school');
            $table->string('preffered_program');
            $table->integer('cluster_no');
            $table->string('preffered_school');
            $table->text('transfer_reason');
            $table->integer('kuccps_password');
            $table->char('mean_grade');
            $table->double('aggregate_points');
            $table->float('cut_off_points');
            $table->float('weighted_clusters');
            $table->string('subject_1');
            $table->string('subject_2');
            $table->string('subject_3');
            $table->string('subject_4');
            $table->string('subject_5');
            $table->string('subject_6');
            $table->string('subject_7');
            $table->string('subject_8');
            $table->char('grade_1');
            $table->char('grade_2');
            $table->char('grade_3');
            $table->char('grade_4');
            $table->char('grade_5');
            $table->char('grade_6');
            $table->char('grade_7');
            $table->char('grade_8');
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
        Schema::dropIfExists('applications');
    }
}
