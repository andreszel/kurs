<?php

namespace App\Models;

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
    protected $attributes = [
        'score' => 5
    ];

    protected $fillable = [
        'title', 'description', 'score', 'publisher_id', 'genre_id'
    ];

    //global Scope
    /* protected static function booted()
    {
        static::addGlobalScope(new LastWeekScope());
    } */

    // relations
    public function genre()
    {
        // table: genres
        // fk: genre_id (SnakeCase -> snake_case) (nazwa metody + suffix id)
        // pk: id
        return $this->belongsTo(Genre::class);
        //return $this->belongsTo(Genre::class, 'foreign_key');
        //return $this->belongsTo(Genre::class, 'foreign_key', 'owner_key');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    // scopes
    public function scopeBest(Builder $query): Builder
    {
        return $query
            // with możemy przenieść do scope
            ->with(['genre', 'publisher'])
            ->where('score', '>', 9)
            ->orderBy('score', 'desc');
    }

    public function scopeGenre(Builder $query, int $genreId): Builder
    {
        //scopes można ze sobą łączyć, można rozszerzać obiekt builer    
        //->genre(3)
        return $query->where('genre_id', $genreId);
    }

    public function scopePublisher(Builder $query, int $publisherId): Builder
    {
        return $query->where('publisher_id', $publisherId);
    }
}
