<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnArgs1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_args1', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name1', 128);
            $table->string('name2');
            $table->string('name3');
            $table->decimal('price1', 8, 2);
            $table->decimal('price2');
            $table->decimal('price3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_args1');
    }
}
