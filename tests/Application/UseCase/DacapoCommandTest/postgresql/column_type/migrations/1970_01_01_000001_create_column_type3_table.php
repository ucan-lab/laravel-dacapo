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
        Schema::create('column_type3', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('votes', false, true);
            $table->mediumText('description');
            $table->morphs('taggable', 'morphs_index');
            $table->uuidMorphs('taggable_uuid', 'uuidMorphs_index');
            $table->multiLineString('positions_multi_line');
            $table->multiPoint('positions_multi_point');
            $table->multiPolygon('positions_multi_polygon');
            $table->nullableMorphs('taggable_nullable', 'nullableMorphs_index');
            $table->nullableUuidMorphs('taggable_nullable_uuid', 'nullableUuidMorphs_index');
            $table->point('position_point');
            $table->polygon('positions_polygon');
            $table->set('flavors', ['strawberry', 'vanilla']);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
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
};
