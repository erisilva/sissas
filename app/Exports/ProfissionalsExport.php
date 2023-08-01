<?php

namespace App\Exports;

use App\Models\Profissional;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ProfissionalsExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export PermissionsExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return Profissional::query()
            ->select('profissionals.nome',
                        'profissionals.matricula',
                        'profissionals.cpf',
                        'profissionals.cns',
                        'profissionals.email',
                        'profissionals.tel',
                        'profissionals.cel',

                        'profissionals.cep',
                        'profissionals.logradouro',
                        'profissionals.numero',
                        'profissionals.complemento',
                        'profissionals.bairro',
                        'profissionals.cidade',
                        'profissionals.uf',

                        'cargos.nome as cargo',
                        'vinculos.nome as vinculo',
                        'vinculo_tipos.nome as tipo_de_vinculo',
                        'carga_horarias.nome as carga_horaria',
                        'profissionals.flexibilizacao',
                        DB::raw('DATE_FORMAT(profissionals.admissao, \'%d/%m/%Y\') AS data_admissao'),
                        'profissionals.registroClasse',
                        'orgao_emissors.nome as orgao_emissor',
                        'profissionals.ufOrgaoEmissor',
                        'profissionals.observacao'
                        
                        
                    )
            ->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id')
            ->join('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id')
            ->join('vinculo_tipos', 'vinculo_tipos.id', '=', 'profissionals.vinculo_tipo_id')
            ->join('carga_horarias', 'carga_horarias.id', '=', 'profissionals.carga_horaria_id')
            ->join('orgao_emissors', 'orgao_emissors.id', '=', 'profissionals.orgao_emissor_id')
            ->orderBy('profissionals.nome', 'asc')
            ->filter($this->filter);
    }

    public function headings(): array
    {
        return [
            "Nome", 
            "Matrícula", 
            "CPF",
            "CNS",
            "E-mail",
            "Telefone",
            "Celular",
            "CEP",
            "Logradouro",
            "Número",
            "Complemento",
            "Bairro",
            "Cidade",
            "UF",
            "Cargo",
            "Vínculo",
            "Tipo de Vínculo",
            "Carga Horária",
            "Flexibilização",
            "Data de Admissão",
            "Registro de Classe",
            "Órgão Emissor",
            "UF Órgão Emissor",
            "Observação"
        
        ];
    }
}
