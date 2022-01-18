<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnType1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_type1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('votes', false, true);
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
            $table->foreignId('user_id');
            $table->geometry('positions');
            $table->geometryCollection('positions_collection');
            $table->softDeletes('deleted_at', 0);
            $table->softDeletesTz('removed_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_type1');
    }
}
