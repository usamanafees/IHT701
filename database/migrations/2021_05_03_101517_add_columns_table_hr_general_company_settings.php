<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableHrGeneralCompanySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_general_company_settings', function (Blueprint $table) {
            $table->boolean('show_filters')->nullable();
            $table->boolean('menu_personal_information')->nullable();
            $table->boolean('menu_expenses')->nullable();
            $table->boolean('menu_documents')->nullable();
            $table->string('price_km')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_general_company_settings', function (Blueprint $table) {
            //
        });
    }
}
