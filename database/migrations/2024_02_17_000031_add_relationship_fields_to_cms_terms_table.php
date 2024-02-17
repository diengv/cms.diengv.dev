<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCmsTermsTable extends Migration
{
    public function up()
    {
        Schema::table('cms_terms', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9508795')->references('id')->on('teams');
        });
    }
}
