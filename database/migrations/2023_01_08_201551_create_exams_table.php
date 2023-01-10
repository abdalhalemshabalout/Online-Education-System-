<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lesson_content_id')
                ->constrained('lesson_contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('exam_name');
            $table->integer('question_number');
            $table->string('exam_time');
            $table->string('success_grade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->date('deleted_at')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDeleted')->nullable()->default(0);
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
        Schema::dropIfExists('exams');
    }
}
