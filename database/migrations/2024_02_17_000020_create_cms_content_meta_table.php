<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsContentMetaTable extends Migration
{
    public function up()
    {
        Schema::create('cms_content_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('value')->nullable();
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
