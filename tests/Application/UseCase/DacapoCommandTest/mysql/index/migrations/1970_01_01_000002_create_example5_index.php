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
            $table->fullText('body3')->language('english');
            $table->fullText('body4', 'example5_body4_fullText')->language('english');
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
            $table->dropFullText(['body3']);
            $table->dropFullText('example5_body4_fullText');
        });
    }
};
