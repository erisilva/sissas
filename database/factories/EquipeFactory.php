<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipe>
 */
class EquipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->word,
            'numero' => $this->faker->randomNumber(),
            'cnes' => $this->faker->word,
            'ine' => $this->faker->word,
            'minima' => $this->faker->randomElement(["s","n"]),
            'unidade_id' => \App\Models\Unidade::inRandomOrder()->first()->id,
        ];
    }
}
