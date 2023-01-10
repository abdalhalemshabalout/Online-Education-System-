<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->bigIncrements('id')->from(111000)->unique();
            $table->foreignId('role_id')->default(2)
                ->constrained('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('identity_number')->unique();
            $table->foreignId('country_id')
                ->constrained('countries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('mother_name');
            $table->string('father_name');
            $table->enum('gender', ['bay', 'bayan']);
            $table->string('place_of_birth');
            $table->date('birth_date');
            $table->string('address');
            $table->string('department_graduated');
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
        Schema::dropIfExists('personals');
    }
}
