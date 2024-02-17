<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsContenTypesTable extends Migration
{
    public function up()
    {
        Schema::table('cms_conten_types', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id', 'image_fk_9508904')->references('id')->on('assets');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508901')->references('id')->on('teams');
        });
    }
}
