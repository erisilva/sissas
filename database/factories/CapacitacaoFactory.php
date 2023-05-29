<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Capacitacao>
 */
class CapacitacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fromDate = $this->faker->dateTimeBetween('-2 year', '-1 month');
        return [
            'inicio' => $fromDate,
            'fim' => Carbon::parse($fromDate)->addDays(rand(1, 90)),
            'cargaHoraria' => $this->faker->randomNumber(2),
            'observacao' => $this->faker->text(),
            'capacitacao_tipo_id' => \App\Models\CapacitacaoTipo::inRandomOrder()->first()->id,
            'profissional_id' => \App\Models\Profissional::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}
