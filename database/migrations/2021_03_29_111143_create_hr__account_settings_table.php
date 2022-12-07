<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_account_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->nullable();
            $table->string('manager')->nullable();
            $table->string('confirmation_key')->nullable();
            $table->string('created_by')->nullable();
            $table->boolean('accepted')->nullable();
            $table->boolean('country_region_id')->nullable();
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
        Schema::dropIfExists('hr__account_settings');
    }
}