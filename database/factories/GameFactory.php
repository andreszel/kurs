<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(1,1000000),
            'steam_appid' => $this->faker->randomNumber(),
            'name' => $this->faker->words(rand(1,3), true),
            'type' => $this->faker->randomElement(['game','dlc','demo']),
            'description' => $this->faker->text,
            'short_description' => $this->faker->text,
            'about' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'website' => $this->faker->url,
            'price_amount' => $this->faker->numberBetween(1,5000),
            'price_currency' => $this->faker->randomElement(['PLN']),
            'metacritic_score' => $this->faker->numberBetween(1,100),
            'metacritic_url' => $this->faker->url,
            'release_date' => $this->faker->date(),
            'languages' => 'Polish, English',
        ];
    }
}
