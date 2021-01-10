<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExample2Index extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('example2', function (Blueprint $table) {
            $table->primary(['no', 'joined_year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('example2', function (Blueprint $table) {
            $table->dropPrimary(['no', 'joined_year']);
        });
    }
}
