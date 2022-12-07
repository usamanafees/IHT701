<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableHrExtradaysCompanySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_extradays_company_settings', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('date')->nullable();
            $table->string('recurrence')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_extradays_company_settings', function (Blueprint $table) {
            //
        });
    }
}
