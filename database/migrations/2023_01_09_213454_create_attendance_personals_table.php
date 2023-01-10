<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('personal_id')
            ->constrained('personals')
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
        Schema::dropIfExists('attendance_personals');
    }
}
