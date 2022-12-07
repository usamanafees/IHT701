<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayssoffRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dayssoff_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id')->nullable();
            $table->string('off_type')->nullable();
            $table->string('period')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('date')->nullable();
            $table->string('period_of_day')->nullable();
            $table->longText('observation')->nullable();
            $table->string('assigned_to')->nullable();
            $table->boolean('approved')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('dayssoff_requests');
    }
}
