<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsPostsTable extends Migration
{
    public function up()
    {
        Schema::create('cms_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_title');
            $table->string('post_name')->nullable();
            $table->longText('post_content')->nullable();
            $table->datetime('post_date')->nullable();
            $table->longText('post_excerpt')->nullable();
            $table->string('post_status');
            $table->string('comment_status')->nullable();
            $table->string('post_password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
