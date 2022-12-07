<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToTabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('items', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('brand_templates', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('invl_items', function (Blueprint $table) {
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       //
    }
}
