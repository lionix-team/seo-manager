<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(/** @scrutinizer ignore-call */config('seo-manager.database.locales_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table(/** @scrutinizer ignore-call */config('seo-manager.database.locales_table'))->insert([
            'name' => /** @scrutinizer ignore-call */config('seo-manager.locale'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(/** @scrutinizer ignore-call */config('seo-manager.database.locales_table'));
    }
}
