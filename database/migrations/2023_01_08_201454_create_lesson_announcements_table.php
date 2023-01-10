<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lesson_id')
                ->constrained('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('head');
            $table->longText('body');
            $table->boolean('isActive')->default(1);
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('lesson_announcements');
    }
}
