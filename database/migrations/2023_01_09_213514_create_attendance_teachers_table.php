<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->boolean('adettence')->default(false);
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
        Schema::dropIfExists('attendance_teachers');
    }
}
