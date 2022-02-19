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
        Schema::table('example5', function (Blueprint $table) {
            $table->fullText('body1');
            $table->fullText('body2', 'example5_body2_fullText');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('example5', function (Blueprint $table) {
            $table->dropFullText(['body1']);
            $table->dropFullText('example5_body2_fullText');
        });
    }
};
