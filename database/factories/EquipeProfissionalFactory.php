<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipeProfissional>
 */
class EquipeProfissionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cargo_id = \App\Models\Cargo::inRandomOrder()->first()->id;
        return [
            'descricao' => $this->faker->word,
            'cargo_id' => $cargo_id,
            'equipe_id' => \App\Models\Equipe::inRandomOrder()->first()->id,
            'profissional_id' => $this->faker->randomElement([null, \App\Models\Profissional::inRandomOrder()->where('cargo_id', $cargo_id)->first()->id]),
        ];
    }
}
