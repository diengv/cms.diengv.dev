<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTermRelationshipsTable extends Migration
{
    public function up()
    {
        Schema::create('cms_term_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('object');
            $table->integer('term_order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
