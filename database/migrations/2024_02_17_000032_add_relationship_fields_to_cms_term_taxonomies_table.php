<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsTermTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::table('cms_term_taxonomies', function (Blueprint $table) {
            $table->unsignedBigInteger('term_id')->nullable();
            $table->foreign('term_id', 'term_fk_9508840')->references('id')->on('cms_terms');
            $table->unsignedBigInteger('taxonomy_id')->nullable();
            $table->foreign('taxonomy_id', 'taxonomy_fk_9508841')->references('id')->on('cms_taxonomies');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id', 'parent_fk_9508848')->references('id')->on('cms_term_taxonomies');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id', 'image_fk_9508906')->references('id')->on('assets');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508847')->references('id')->on('teams');
        });
    }
}
