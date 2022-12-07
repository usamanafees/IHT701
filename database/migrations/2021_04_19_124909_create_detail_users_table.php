<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('civil_state')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_kinship')->nullable();
            $table->string('citizen_card')->nullable();
            $table->string('fiscal_id')->nullable();
            $table->string('social_security')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('car_plate')->nullable();
            $table->string('other_docs')->nullable();
            $table->string('academic_degree')->nullable();
            $table->string('school')->nullable();
            $table->string('course')->nullable();
            $table->string('number_dependents')->nullable();
            $table->string('deficiencies')->nullable();
            $table->string('income_ownership')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_users');
    }
}
