<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnModifiers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_modifiers1', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name')->charset('utf8')->collation('utf8_unicode_ci')->comment('my comment')->default('test value')->nullable();
            $table->integer('price')->unsigned();
            $table->integer('count')->unsigned();
            $table->integer('total_stored')->storedAs('price * count');
            $table->integer('total_virtual')->virtualAs('price * count');
            $table->integer('total_generated')->generatedAs('price * count');
            $table->timestamp('created_at')->useCurrent();
            $table->integer('seq')->always();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_modifiers1');
    }
}
