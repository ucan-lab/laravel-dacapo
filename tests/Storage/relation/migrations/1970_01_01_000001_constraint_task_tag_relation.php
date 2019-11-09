<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintTaskTagRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_tag', function (Blueprint $table) {
            $table->foreign('task_id', 'task_tag_custom_task_id_foreign')->references('id')->on('tasks');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_tag', function (Blueprint $table) {
            $table->dropForeign('task_tag_custom_task_id_foreign');
            $table->dropForeign(['tag_id']);
        });
    }
}
