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
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'equipe_id' => \App\Models\Equipe::inRandomOrder()->first()->id,
            'profissional_id' => \App\Models\Profissional::inRandomOrder()->first()->id,
            'unidade_id' => \App\Models\Unidade::inRandomOrder()->first()->id,
            'historico_tipo_id' => \App\Models\HistoricoTipo::inRandomOrder()->first()->id,
        ];
    }
}
