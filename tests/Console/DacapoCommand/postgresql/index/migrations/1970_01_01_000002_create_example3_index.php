<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExample3Index extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('example3', function (Blueprint $table) {
            $table->index(['name', 'email'], 'users_name_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('example3', function (Blueprint $table) {
            $table->dropIndex('users_name_index');
        });
    }
}
