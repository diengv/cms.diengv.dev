<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTermsTable extends Migration
{
    public function up()
    {
        Schema::create('cms_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('term_group')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
