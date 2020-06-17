<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assignment_course_id');
            $table->integer('assignment_teacher_id');
            $table->integer('assignment_student_id');
            $table->integer('assignment_total_marks');
            $table->integer('assignment_obtained_marks');
            $table->string('assignment_title');
            $table->integer('assignment_id');
            $table->string('assignment_file_student')->nullable();
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
        Schema::dropIfExists('assignment_students');
    }
}
