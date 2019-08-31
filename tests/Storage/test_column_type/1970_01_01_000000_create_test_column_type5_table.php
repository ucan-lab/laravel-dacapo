<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestColumnType5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_column_type5', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->tinyInteger('votes');
            $table->unsignedBigInteger('votes_ubi');
            $table->unsignedInteger('votes_ui');
            $table->unsignedMediumInteger('votes_umi');
            $table->unsignedSmallInteger('votes_usi');
            $table->unsignedTinyInteger('votes_uti');
            $table->unsignedDecimal('amount', 8, 2);
            $table->uuid('uuid');
            $table->year('birth_year');
        });

        DB::statement("ALTER TABLE test_column_type5 COMMENT ''");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_column_type5');
    }
}
