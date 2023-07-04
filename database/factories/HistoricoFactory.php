<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historico>
 */
class HistoricoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->date(),
            'observacao' => $this->faker->word,
            'user_id' => \App\Models\User::factory(),
            'equipe_id' => \App\Models\Equipe::factory(),
            'profissional_id' => \App\Models\Profissional::factory(),
            'unidade_id' => \App\Models\Unidade::factory(),
            'historico_tipo_id' => \App\Models\HistoricoTipo::factory(),
        ];
    }
}
