<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsPostsTable extends Migration
{
    public function up()
    {
        Schema::table('cms_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_9508902')->references('id')->on('cms_conten_types');
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->foreign('thumbnail_id', 'thumbnail_fk_9508903')->references('id')->on('assets');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508893')->references('id')->on('teams');
        });
    }
}
