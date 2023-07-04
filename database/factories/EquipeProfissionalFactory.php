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
        return [
            'descricao' => $this->faker->word,
            'cargo_id' => \App\Models\Cargo::factory(),
            'equipe_id' => \App\Models\Equipe::factory(),
            'profissional_id' => \App\Models\Profissional::factory(),
        ];
    }
}
