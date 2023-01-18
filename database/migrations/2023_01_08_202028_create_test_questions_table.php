<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(900000000)->unique();
            $table->integer('question_type')->default(1);
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('question_number');
            $table->string('question');
            $table->string('answer_one');
            $table->string('answer_two');
            $table->string('answer_three')->nullable();
            $table->string('answer_four')->nullable();
            $table->string('answer_five')->nullable();
            $table->string('correct_answer')->nullable();
            $table->double('answer_point')->nullable();
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
        Schema::dropIfExists('test_questions');
    }
}
