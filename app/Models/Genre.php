<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    /*public function games()
    {
        // table: games
        // fk: genre_id (SnakeCase -> snake_case) (nazwa metody + suffix id)
        // pk: id
        // domyślnie nie musimy podawać fk i pk, gdyby był inaczej nazwany to musimy podać bo wg wzoru eloquent nie wymyśli nazwy
        //return $this->hasMany(Game::class, 'genre_id');
        //return $this->hasMany(Game::class, 'genre_id', 'id');
        //return $this->hasMany('App\Models\Game');

        return $this->hasMany(Game::class);
    }*/

    public function games()
    {
        return $this->belongsToMany('App\Models\Game', 'gameGenres');
    }
}

//$genre = Genre::find(322);
//$games = $genre->games();
//$games[4] - 4 elemenet tablicy
