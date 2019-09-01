<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestColumnType2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_column_type2', function (Blueprint $table) {
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
        Schema::dropIfExists('test_column_type2');
    }
}
