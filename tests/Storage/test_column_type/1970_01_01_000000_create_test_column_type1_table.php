<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestColumnType1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_column_type1', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('votes');
            $table->binary('data');
            $table->boolean('confirmed');
            $table->char('name', 100);
            $table->date('created_date');
            $table->dateTime('created_at');
            $table->dateTimeTz('created_tz');
            $table->decimal('amount', 8, 2);
            $table->double('total', 8, 2);
            $table->enum('level', ['easy', 'hard']);
            $table->float('subtotal', 8, 2);
            $table->geometry('positions');
            $table->geometryCollection('positions_collection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_column_type1');
    }
}
