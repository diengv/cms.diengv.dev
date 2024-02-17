<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsContentMetaTable extends Migration
{
    public function up()
    {
        Schema::table('cms_content_meta', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_9508911')->references('id')->on('cms_posts');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508915')->references('id')->on('teams');
        });
    }
}
