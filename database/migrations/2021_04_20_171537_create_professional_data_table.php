<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('employee_code')->nullable();
            $table->string('prof_phone')->nullable();
            $table->string('prof_email')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('job_role')->nullable();
            $table->string('job_role_desc')->nullable();
            $table->string('manager')->nullable();
            $table->string('base_salary')->nullable();
            $table->string('expenses')->nullable();
            $table->string('food_allowance')->nullable();
            $table->string('value_per_hour')->nullable();
            $table->string('felexible_work_hours')->nullable();
            $table->string('observations')->nullable();
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
