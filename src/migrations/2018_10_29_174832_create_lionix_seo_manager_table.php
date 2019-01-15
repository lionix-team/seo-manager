<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLionixSeoManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(/** @scrutinizer ignore-call */config('seo-manager.database.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('uri')->nullable();
            $table->jsonb('params')->nullable();
            $table->jsonb('mapping')->nullable();
            $table->jsonb('keywords');
            $table->string('description')->nullable();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('url')->nullable();
            $table->jsonb('title_dynamic')->nullable();
            $table->jsonb('og_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(/** @scrutinizer ignore-call */config('seo-manager.database.table'));
    }
}
