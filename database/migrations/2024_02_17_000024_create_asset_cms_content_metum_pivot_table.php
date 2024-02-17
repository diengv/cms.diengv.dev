<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetCmsContentMetumPivotTable extends Migration
{
    public function up()
    {
        Schema::create('asset_cms_content_metum', function (Blueprint $table) {
            $table->unsignedBigInteger('cms_content_metum_id');
            $table->foreign('cms_content_metum_id', 'cms_content_metum_id_fk_9508916')->references('id')->on('cms_content_meta')->onDelete('cascade');
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id', 'asset_id_fk_9508916')->references('id')->on('assets')->onDelete('cascade');
        });
    }
}
