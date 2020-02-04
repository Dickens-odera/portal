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
            $table->string('student_name')->nullable();
            $table->string('reg_number')->nullable();
            $table->integer('student_phone')->nullable();
            $table->integer('kcse_index')->nullable();
            $table->year('kcse_year')->nullable();
            $table->string('present_program')->nullable();
            $table->string('present_school')->nullable();
            $table->string('preffered_program')->nullable();
            $table->integer('cluster_no')->nullable();
            $table->string('preffered_school')->nullable();
            $table->text('transfer_reason')->nullable();
            $table->integer('kuccps_password')->nullable();
            $table->char('mean_grade')->nullable();
            $table->double('aggregate_points')->nullable();
            $table->float('cut_off_points')->nullable();
            $table->float('weighted_clusters')->nullable();
            $table->string('subject_1')->nullable();
            $table->string('subject_2')->nullable();
            $table->string('subject_3')->nullable();
            $table->string('subject_4')->nullable();
            $table->string('subject_5')->nullable();
            $table->string('subject_6')->nullable();
            $table->string('subject_7')->nullable();
            $table->string('subject_8')->nullable();
            $table->char('grade_1')->nullable();
            $table->char('grade_2')->nullable();
            $table->char('grade_3')->nullable();
            $table->char('grade_4')->nullable();
            $table->char('grade_5')->nullable();
            $table->char('grade_6')->nullable();
            $table->char('grade_7')->nullable();
            $table->char('grade_8')->nullable();
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
