<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::connection('mysql')->create('games', function (Blueprint $table) {});
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description', 100)->nullable();
            //$table->string('publisher', 100)->comment('game publisher');
            $table->foreignId('publisher_id')
                ->constrained('publishers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //$table->unsignedBigInteger('genre_id');
            //$table->foreignId('genre_id')->references('id')->on('genres');
            $table->foreignId('genre_id')
                ->constrained('genres')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('score')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        // zmiana nazwy tabli
        //Schema::rename('old_name', 'new_name');
        if (Schema::hasTable('name_table')) {
            //...
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
        //$table->dropForeign('games_genre_id_foreign');
        // jeżeli usuwamy tabelę która nie istnieje to dostaniemy error
        //Schema::drop('games');
    }
}
