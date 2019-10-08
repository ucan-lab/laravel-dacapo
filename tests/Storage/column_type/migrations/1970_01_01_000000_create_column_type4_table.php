<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnType4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_type4', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('votes');
            $table->string('name', 100);
            $table->text('description');
            $table->time('sunrise');
            $table->timeTz('sunrise_tz');
            $table->timestamp('added_on');
            $table->timestampTz('added_on_tz');
            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_type4');
    }
}
