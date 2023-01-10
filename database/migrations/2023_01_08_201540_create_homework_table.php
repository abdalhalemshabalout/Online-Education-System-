<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lesson_content_id')
                ->constrained('lesson_contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('document')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('isActive')->default(1);
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
        Schema::dropIfExists('homework');
    }
}
