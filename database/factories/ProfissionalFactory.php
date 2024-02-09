<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profissional>
 */
class ProfissionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'nome' => $this->faker->name(),
                'matricula' => $this->faker->regexify('[A-Za-z0-9]{8}'),
                'cns' => $this->faker->regexify('[A-Za-z0-9]{12}'),
                'cpf' => $this->faker->cpf(),
                'flexibilizacao' => $this->faker->randomElement(['Nenhum', 'Extensão', 'Redução']),
                'admissao' => $this->faker->dateTimeBetween('-7 year', '-1 month'),
                'observacao' => $this->faker->sentence(),
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
                'registroClasse' => $this->faker->regexify('[A-Za-z0-9]{16}'),
                'ufOrgaoEmissor' => $this->faker->randomElement(['mg', 'sp', 'jl', 'rj', 'sc', 'pr', 'rs', 'es', 'go', 'mt', 'ms', 'ac', 'al', 'ap', 'am', 'ba', 'ce', 'df', 'ma', 'pa', 'pb', 'pe', 'pi', 'rn', 'ro', 'rr', 'se', 'to']),
                'cargo_id' => \App\Models\Cargo::inRandomOrder()->first()->id,
                'carga_horaria_id' => \App\Models\CargaHoraria::inRandomOrder()->first()->id,
                'vinculo_id' => \App\Models\Vinculo::inRandomOrder()->first()->id,
                'vinculo_tipo_id' => \App\Models\VinculoTipo::inRandomOrder()->first()->id,
                'orgao_emissor_id' => \App\Models\OrgaoEmissor::inRandomOrder()->first()->id,
                'deleted_at' => rand(0,12) == 5 ? $this->faker->dateTimeThisYear() : null,
        ];
    }
}
