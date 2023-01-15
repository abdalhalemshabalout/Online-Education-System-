<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_infos', function (Blueprint $table) {
            $table->bigIncrements('id')->from(111111)->unique();
            $table->foreignId('role_id')->default(5)
                ->constrained('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->enum('parent', ['father', 'mather']);
            $table->string('telephone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDeleted')->nullable()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('parent_infos');
    }
}
