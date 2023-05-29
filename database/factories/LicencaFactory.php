<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Licenca>
 */
class LicencaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fromDate = $this->faker->dateTimeBetween('-2 year', '-1 month');
        $toDate = Carbon::parse($fromDate)->addDays(rand(7, 30));
        return [
            'inicio' => $fromDate,
            'fim' => $toDate,
            'observacao' => $this->faker->text(),
            'licenca_tipo_id' => \App\Models\LicencaTipo::inRandomOrder()->first()->id,
            'profissional_id' => \App\Models\Profissional::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}
