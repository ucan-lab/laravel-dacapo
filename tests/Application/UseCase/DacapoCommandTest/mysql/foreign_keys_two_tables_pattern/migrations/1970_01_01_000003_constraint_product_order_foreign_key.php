<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintProductOrderForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_order', function (Blueprint $table) {
            $table->foreign(['product_category', 'product_id'])->references(['category', 'id'])->on('product')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_order', function (Blueprint $table) {
            $table->dropForeign(['product_category', 'product_id']);
            $table->dropForeign(['customer_id']);
        });
    }
}
