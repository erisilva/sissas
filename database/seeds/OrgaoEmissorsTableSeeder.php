<?php

use Illuminate\Database\Seeder;

class OrgaoEmissorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // importante colocar o id do não possui como um
        // que será usado como default no cadastro do profissional
        DB::table('orgao_emissors')->insert([
            'id' => 1,
            'descricao' => 'Não Possui',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 2,
            'descricao' => 'Conselho Regional de Assist. Social',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 3,
            'descricao' => 'Conselho Regional de Enfermagem',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 4,
            'descricao' => 'Conselho Regional de Farmácia',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 5,
            'descricao' => 'Conselho Regional de Fisioterapia e Terapia Ocupacional',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 6,
            'descricao' => 'Conselho Regional de Medicina',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 7,
            'descricao' => 'Conselho Regional de Medicina Veterinária',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 8,
            'descricao' => 'Conselho Regional de Nutrição',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 9,
            'descricao' => 'Conselho Regional de Odontologia',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 10,
            'descricao' => 'Conselho Regional de Psicologia',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 11,
            'descricao' => 'Outros Emissores',
        ]);

        DB::table('orgao_emissors')->insert([
            'id' => 12,
            'descricao' => 'Documento Estrangeiro',
        ]);
    }
}
