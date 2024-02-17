<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTermTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('cms_term_taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('description')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
