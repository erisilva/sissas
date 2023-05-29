<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidade>
 */
class UnidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company(),
            'porte' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'tel' => $this->faker->phoneNumber(),
            'cel' => $this->faker->cellphoneNumber(),
            'email' => $this->faker->email(),
            'cep' => $this->faker->landline(),
            'logradouro' => $this->faker->streetName(),
            'bairro' => $this->faker->streetName(),
            'numero' => $this->faker->postcode(),
            'complemento' => $this->faker->word(4),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'distrito_id' => \App\Models\Distrito::inRandomOrder()->first()->id,
        ];
    }
}
