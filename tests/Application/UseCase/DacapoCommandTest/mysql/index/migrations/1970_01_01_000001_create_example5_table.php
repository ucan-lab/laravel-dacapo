<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example5', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('body1');
            $table->longText('body2');
            $table->longText('body3');
            $table->longText('body4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('example5');
    }
};
