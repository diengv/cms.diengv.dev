<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('cms_taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('hierarchical')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
