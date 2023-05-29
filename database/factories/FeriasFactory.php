<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ferias>
 */
class FeriasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fromDate = $this->faker->dateTimeBetween('-2 year', '-1 month');
        $toDate = Carbon::parse($fromDate)->addDays(rand(1, 30));
        return [
            'inicio' => $fromDate,
            'fim' => $toDate,
            'justificativa' => $this->faker->text(),
            'observacao' => $this->faker->text(),
            'ferias_tipo_id' => \App\Models\FeriasTipo::inRandomOrder()->first()->id,
            'profissional_id' => \App\Models\Profissional::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}
