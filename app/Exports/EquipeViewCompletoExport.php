<?php

namespace App\Exports;

use App\Models\EquipeView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class EquipeViewCompletoExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export EquipeViewCompletoExport --model=Equipe
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
        return EquipeView::query()
            ->select(   DB::raw('COALESCE(nome, \' \') AS profissional'),
                        DB::raw('COALESCE(matricula, \' \') AS matricula'),
                        DB::raw('COALESCE(cpf, \' \') AS cpf'),
                        DB::raw('COALESCE(cns, \' \') AS cns'),
                        DB::raw('COALESCE(email, \' \') AS email'),
                        DB::raw('COALESCE(tel, \' \') AS tel'),
                        DB::raw('COALESCE(cel, \' \') AS cel'),
                        DB::raw('COALESCE(cep, \' \') AS cep'),
                        DB::raw('COALESCE(logradouro, \' \') AS logradouro'),
                        DB::raw('COALESCE(bairro, \' \') AS bairro'),
                        DB::raw('COALESCE(numero, \' \') AS numero'),
                        DB::raw('COALESCE(complemento, \' \') AS complemento'),
                        DB::raw('COALESCE(cidade, \' \') AS cidade'),
                        DB::raw('COALESCE(uf, \' \') AS uf'),
                        DB::raw('COALESCE(cargo_profissional, \' \') AS cargo_profissional'),
                        DB::raw('COALESCE(vinculo, \' \') AS vinculo'),
                        DB::raw('COALESCE(tipo_de_vinculo, \' \') AS tipo_de_vinculo'),
                        DB::raw('COALESCE(carga_horaria, \' \') AS carga_horaria'),
                        DB::raw('COALESCE(flexibilizacao, \' \') AS flexibilizacao'),
                        DB::raw('DATE_FORMAT(admissao, \'%d/%m/%Y\') AS admissao'),
                        DB::raw('COALESCE(registroClasse, \' \') AS registroClasse'),
                        DB::raw('COALESCE(orgao_emissor, \' \') AS orgao_emissor'),
                        DB::raw('COALESCE(ufOrgaoEmissor, \' \') AS ufOrgaoEmissor'),                        
                        'cargo as cargo_vaga',
                        'equipe',                        
                        'equipe_numero',
                        'cnes',
                        'ine',                        
                        'minima',
                        'equipe_tipo',
                        'unidade',
                        'distrito',
                        )
            ->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Nome", 
                "Matrícula", 
                "CPF",
                "CNS",
                "E-mail",
                "Telefone",
                "Celular",
                "CEP",
                "Logradouro",
                "Bairro",
                "Número",
                "Complemento",
                "Cidade",
                "UF",
                "Cargo",
                "Vínculo",
                "Tipo de Vínculo",
                "Carga Horária",
                "Flexibilização",
                "Admissão",
                "Registro de Classe",
                "Órgão Emissor",
                "UF Órgão Emissor",
                "Cargo da Vaga",
                "Equipe",
                "Número da Equipe",
                "CNES",
                "INE",
                "Mínima",
                "Tipo de Equipe",
                "Unidade",
                "Distrito",                
            
            ];
    }
}
