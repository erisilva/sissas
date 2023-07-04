<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class HistoricoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('historico_tipos')->insert([
            'id' => 1,
            'descricao' => 'Profissional registrado no sistema',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 2,
            'descricao' => 'Registro do profissional alterado',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 3,
            'descricao' => 'Registro do profissional enviado à lixeira',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 4,
            'descricao' => 'Registro do profissional restaurado da lixeira',
        ]);
        // férias
        DB::table('historico_tipos')->insert([
            'id' => 5,
            'descricao' => 'Foi cadastrado uma férias para o profissional',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 6,
            'descricao' => 'Foi excluído uma férias do profissional',
        ]);
        // licenças
        DB::table('historico_tipos')->insert([
            'id' => 7,
            'descricao' => 'Foi cadastrado uma licença para o profissional',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 8,
            'descricao' => 'Foi excluído uma licença do profissional',
        ]);
        // capacitações
        DB::table('historico_tipos')->insert([
            'id' => 9,
            'descricao' => 'Foi cadastrado uma capacitação para o profissional',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 10,
            'descricao' => 'Foi excluído uma capacitação do profissional',
        ]);
        // profissionais nas unidade
        DB::table('historico_tipos')->insert([
            'id' => 11,
            'descricao' => 'Profissional foi vinculado a uma unidade',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 12,
            'descricao' => 'Profissional foi desvinculado de uma unidade',
        ]);
        // profisionais nas equipes
        DB::table('historico_tipos')->insert([
            'id' => 13,
            'descricao' => 'Profissional foi vinculado a uma equipe',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 14,
            'descricao' => 'Profissional foi desvinculado de uma equipe',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 15,
            'descricao' => 'A carga horária no registro do profissional foi alterado',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 16,
            'descricao' => 'O cargo no registro do profissional foi alterado',
        ]);
        DB::table('historico_tipos')->insert([
            'id' => 17,
            'descricao' => 'O vínculo no registro do profissional foi alterado',
        ]);
    }
}
