<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsTermRelationshipsTable extends Migration
{
    public function up()
    {
        Schema::table('cms_term_relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('term_taxonomy_id')->nullable();
            $table->foreign('term_taxonomy_id', 'term_taxonomy_fk_9508851')->references('id')->on('cms_term_taxonomies');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508856')->references('id')->on('teams');
        });
    }
}
