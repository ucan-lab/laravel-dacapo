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
        Schema::create('column_type5', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->tinyInteger('votes', false, true);
            $table->unsignedBigInteger('votes_ubi');
            $table->unsignedInteger('votes_ui');
            $table->unsignedMediumInteger('votes_umi');
            $table->unsignedSmallInteger('votes_usi');
            $table->unsignedTinyInteger('votes_uti');
            $table->unsignedDecimal('amount', 8, 2);
            $table->uuid('uuid');
            $table->year('birth_year');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_type5');
    }
};
