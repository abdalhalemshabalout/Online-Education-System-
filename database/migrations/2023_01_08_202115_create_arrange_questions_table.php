<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrangeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrange_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_type')->default(5);
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('question_number');
            $table->string('question')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('arrange_questions');
    }
}
