<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterModelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('genres')->truncate();
        Schema::dropIfExists('games');

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('steam_appid')->index();
            $table->integer('relation_id')->nullable()->index();
            $table->string('name', 100)->index();
            $table->string('type', 20)->default('game')->index();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('about')->nullable();
            $table->string('image', 200);
            $table->string('website', 200)->nullable();
            $table->integer('price_amount')->nullable();
            $table->string('price_currency', 3)->nullable();

            $table->string('metacritic_score', 10)->nullable();
            $table->string('metacritic_url', 150)->nullable();
            $table->string('release_date', 30);
            $table->string('languages', 100)->nullable();

            $table->timestamps();
        });

        Schema::create('gameGenres', function (Blueprint $table) {
            $table->integer('game_id')->index();
            $table->integer('genre_id')->index();

            $table->index(['game_id', 'genre_id']);
        });

        // tabela publishers + łącząca
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->timestamps();

            //$table->unique('name');
        });

        Schema::create('gamePublishers', function (Blueprint $table) {
            $table->integer('game_id')->index();
            $table->integer('publisher_id')->index();

            $table->index(['game_id', 'publisher_id']);
        });

        // tabela developers + łącząca
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->timestamps();
        });

        Schema::create('gameDevelopers', function (Blueprint $table) {
            $table->integer('game_id')->index();
            $table->integer('developer_id')->index();

            $table->index(['game_id', 'developer_id']);
        });

        Schema::create('screenshots', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id')->index();
            $table->string('thumbnail', 100);
            $table->string('url', 100);
            $table->timestamps();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id')->index();
            $table->integer('original_id')->index();
            $table->string('name', 80);
            $table->boolean('highlight');
            $table->string('thumbnail', 100);
            $table->string('webm_480', 100);
            $table->string('webm_url', 100);
            $table->string('mp4_480', 100);
            $table->string('mp4_url', 100);
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
        Schema::dropIfExists('games');
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('developers');
        Schema::dropIfExists('screenshots');
        Schema::dropIfExists('movies');

        Schema::dropIfExists('gameDevelopers');
        Schema::dropIfExists('gamePublishers');
        Schema::dropIfExists('gameGenres');
    }
}
