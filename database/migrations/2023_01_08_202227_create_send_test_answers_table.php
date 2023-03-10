<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_test_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained('test_questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('answer')->nullable();
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
        Schema::dropIfExists('send_test_answers');
    }
}
