<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('classroom_id')
                ->constrained('classrooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('branch_id')
                ->constrained('branches')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('lesson_id')
                ->constrained('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('lesson_teachers');
    }
}
