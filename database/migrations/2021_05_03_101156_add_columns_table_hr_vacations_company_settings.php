<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableHrVacationsCompanySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_vacations_company_settings', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('days_limit')->nullable();
            $table->string('period')->nullable();
            $table->string('bookings')->nullable();
            $table->boolean('food_subsidy')->nullable();
            $table->boolean('paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_vacations_company_settings', function (Blueprint $table) {
            //
        });
    }
}
