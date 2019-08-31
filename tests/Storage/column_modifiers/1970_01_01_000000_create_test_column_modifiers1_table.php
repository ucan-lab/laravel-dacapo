<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestColumnModifiers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_column_modifiers1', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name')->charset('utf8')->collation('utf8_unicode_ci')->comment('my comment')->comment('test value')->nullable(true);
            $table->integer('price')->unsigned();
            $table->integer('count')->unsigned();
            $table->integer('total_stored')->storedAs('price * count');
            $table->integer('total_virtual')->virtualAs('price * count');
            $table->integer('total_generated')->generatedAs('price * count');
            $table->timestamp('created_at')->useCurrent();
            $table->integer('seq')->always();
        });

        DB::statement("ALTER TABLE test_column_modifiers1 COMMENT ''");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_column_modifiers1');
    }
}
