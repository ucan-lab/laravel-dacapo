<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnType2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_type2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('votes');
            $table->ipAddress('visitor');
            $table->json('options');
            $table->jsonb('options_b');
            $table->lineString('positions');
            $table->longText('description');
            $table->macAddress('device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_type2');
    }
}
