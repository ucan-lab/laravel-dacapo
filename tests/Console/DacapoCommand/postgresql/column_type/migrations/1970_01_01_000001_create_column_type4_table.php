<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->smallInteger('votes', false, true);
            $table->string('name', 100);
            $table->text('description');
            $table->time('sunrise', 0);
            $table->timeTz('sunrise_tz', 0);
            $table->timestamp('added_on', 0);
            $table->timestampTz('added_on_tz', 0);
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
