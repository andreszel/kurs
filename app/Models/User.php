<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'password_text',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function games()
    {
        //nazwa modelu, do którego chcemy się dobrać poprzez tabelę pośredniczącą i nazwę tabeli pośredniczącej
        return $this->belongsToMany(Game::class, 'userGames')
            ->withPivot('rate')
            ->with('genres');
    }

    public function addGame(Game $game): void
    {
        $this->games()->save($game);
    }

    public function removeGame(Game $game): void
    {
        $this->games()->detach($game->id);
    }

    public function hasGame(int $gameId): bool
    {
        $game = $this->games()->where('userGames.game_id', $gameId)->first();

        return (bool) $game;
    }

    public function rateGame(Game $game, ?int $rate): void
    {
        $this->games()->updateExistingPivot($game, ['rate' => $rate]);
    }
}
