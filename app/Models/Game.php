<?php

namespace App\Models\Game;

use App\Models\Scope\LastWeekScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    // domyślnie jest nazwa klasy game+s, jeżeli inna nazwa tabeli to podajemy dokładnie jaka
    protected $table = 'games';
    // domyślna nazwa to id, jeżeli mamy klucz główny o innej nazwie to podajemy jak się nazywa
    protected $primaryKey = 'id';
    // eloquent domyślnie zakłada i tworzy kolumny created_at, updated_at, jeżeli nie chcemy, aby były tworzone takie kolumny to ustawiamy właściwość na false
    //protected $timestamps = false;
    // w tej tablicy możemy przypisywać wartości domyślne dla pól
    /* protected $attributes = [
        'score' => 5
    ]; */
    protected $attributes = [
        'metacritic_score' => null
    ];

    protected $casts = [
        'metacritic_score' => 'integer',
        'steam_appid' => 'integer',
    ];

    /* protected $fillable = [
        'title', 'description', 'score', 'publisher_id', 'genre_id'
    ]; */

    // ====> ATTRIBUTES <====

    public function getScoreAttribute(): ?int
    {
        return $this->metacritic_score;
    }

    public function getSteamIdAttribute(): int
    {
        return $this->steam_appid;
    }

    public function getShortDescriptionAttribute()
    {
        return $this->attributes['short_description'];
    }

    //global Scope
    /* protected static function booted()
    {
        static::addGlobalScope(new LastWeekScope());
    } */

    // ====> RELATIONS <====
    public function genres()
    {
        // table: genres
        // fk: genre_id (SnakeCase -> snake_case) (nazwa metody + suffix id)
        // pk: id
        //return $this->belongsTo(Genre::class);
        //return $this->belongsTo(Genre::class, 'foreign_key');
        //return $this->belongsTo(Genre::class, 'foreign_key', 'owner_key');
        return $this->belongsToMany('App\Models\Genre', 'gameGenres');
    }

    public function publishers()
    {
        //return $this->belongsTo(Publisher::class);
        return $this->belongsToMany('App\Models\Publisher', 'gamePublishers');
    }

    // ====> SCOPES <====
    public function scopeBest(Builder $query): Builder
    {
        return $query
            // with możemy przenieść do scope
            ->with(['genres', 'publishers'])
            ->where('metacritic_score', '>=' , 75)
            ->orderBy('metacritic_score', 'desc');
    }

    public function scopeGenre(Builder $query, string $genre): Builder
    {
        //scopes można ze sobą łączyć, można rozszerzać obiekt builer    
        //->genre(3)
        //return $query->where('genre_id', $genreId);
        return $query->where('genres', $genre);
    }

    public function scopePublisher(Builder $query, string $publisher): Builder
    {
        //return $query->where('publisher_id', $publisherId);
        return $query->where('publishers', $publisher);
    }
}
