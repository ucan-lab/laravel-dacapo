<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnType3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_type3', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('votes');
            $table->mediumText('description');
            $table->morphs('taggable');
            $table->uuidMorphs('taggable_uuid');
            $table->multiLineString('positions_multi_line');
            $table->multiPoint('positions_multi_point');
            $table->multiPolygon('positions_multi_polygon');
            $table->nullableMorphs('taggable_nullable', 'custom_taggable_nullable_index');
            $table->nullableMorphs('taggable_nullable_uuid', 'custom_taggable_nullable_nullable_morphs_index');
            $table->point('position_point');
            $table->polygon('positions_polygon');
            $table->set('flavors', ['strawberry', 'vanilla']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_type3');
    }
}
