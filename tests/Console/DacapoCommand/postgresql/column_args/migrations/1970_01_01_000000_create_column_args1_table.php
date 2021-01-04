<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name1');
            $table->string('name2');
            $table->string('name3', 128);
            $table->decimal('price1');
            $table->decimal('price2');
            $table->decimal('price3', 8, 2);
            $table->decimal('price4', 8);
            $table->decimal('price5', 8);
            $table->decimal('price6', 8, 2);
            $table->decimal('price7', 8);
            $table->timestamps();
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
        Schema::dropIfExists('column_args1');
    }
}
