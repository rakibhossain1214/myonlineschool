<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assignment_course_id');
            $table->integer('assignment_teacher_id');
            $table->integer('assignment_total_marks');
            $table->string('assignment_title');
            $table->string('assignment_description');
            $table->string('assignment_file_teacher')->nullable();
            $table->string('assignment_deadline');
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
        Schema::dropIfExists('assignment_teachers');
    }
}
