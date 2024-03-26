<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Arr;

class Profissional extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 'matricula', 'cns', 'cpf', 'flexibilizacao', 'admissao', 'observacao', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cargo_id', 'carga_horaria_id', 'vinculo_id', 'vinculo_tipo_id', 'orgao_emissor_id', 'registroClasse', 'ufOrgaoEmissor', 'tipo'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'admissao' => 'datetime',
      ];

        /**
     * Filter
     *
     */
    public function scopeFilter($query, array $filters) : void
    {

        
        // start session values if not yet initialized
        if (!session()->exists('profissional_nome')){
            session(['profissional_nome' => '']);
        }

        if (!session()->exists('profissional_matricula')){
            session(['profissional_matricula' => '']);
        }

        if (!session()->exists('profissional_cpf')){
            session(['profissional_cpf' => '']);
        }

        if (!session()->exists('profissional_cns')){
            session(['profissional_cns' => '']);
        }
        
        if (!session()->exists('profissional_cargo_id')){
            session(['profissional_cargo_id' => '']);
        }

        if (!session()->exists('profissional_vinculo_id')){
            session(['profissional_vinculo_id' => '']);
        }

        if (!session()->exists('profissional_vinculo_tipo_id')){
            session(['profissional_vinculo_tipo_id' => '']);
        }

        if (!session()->exists('profissional_carga_horaria_id')){
            session(['profissional_carga_horaria_id' => '']);
        }

        if (!session()->exists('profissional_flexibilizacao')){
            session(['profissional_flexibilizacao' => '']);
        }
        
        
        

        // update session values if the request has a value
        // ['nome', 'matricula', 'cpf', 'cns', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'carga_horaria_id', 'flexibilizacao']
        // ['nome' => '', 'matricula' => '', 'cpf' => '', 'cms' => '', 'cargo_id' => '', 'vinculo_id' => '', 'vinculo_tipo_id' => '', 'carga_horaria_id' => '', 'flexibilizacao' => '']
        // ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cns' => request()->input('cns'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'flexibilizacao' => request()->input('flexibilizacao')]
        if (Arr::exists($filters, 'nome')) {
            session(['profissional_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'matricula')) {
            session(['profissional_matricula' => $filters['matricula'] ?? '']);
        }

        if (Arr::exists($filters, 'cpf')) {
            session(['profissional_cpf' => $filters['cpf'] ?? '']);
        }

        if (Arr::exists($filters, 'cns')) {
            session(['profissional_cns' => $filters['cns'] ?? '']);
        }

        if (Arr::exists($filters, 'cargo_id')) {
            session(['profissional_cargo_id' => $filters['cargo_id'] ?? '']);
        }
        
        if (Arr::exists($filters, 'vinculo_id')) {
            session(['profissional_vinculo_id' => $filters['vinculo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'vinculo_tipo_id')) {
            session(['profissional_vinculo_tipo_id' => $filters['vinculo_tipo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'carga_horaria_id')) {
            session(['profissional_carga_horaria_id' => $filters['carga_horaria_id'] ?? '']);
        }

        if (Arr::exists($filters, 'flexibilizacao')) {
            session(['profissional_flexibilizacao' => $filters['flexibilizacao'] ?? '']);
        }
        

        
        // query if session filters are not empty
        if (trim(session()->get('profissional_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('profissional_nome') . '%');
        }

        if (trim(session()->get('profissional_matricula')) !== '') {
            $query->where('matricula', 'like', '%' . session()->get('profissional_matricula') . '%');
        }

        if (trim(session()->get('profissional_cpf')) !== '') {
            $query->where('cpf', 'like', '%' . session()->get('profissional_cpf') . '%');
        }

        if (trim(session()->get('profissional_cns')) !== '') {
            $query->where('cns', 'like', '%' . session()->get('profissional_cns') . '%');
        }

        if (trim(session()->get('profissional_cargo_id')) !== '') {
            $query->where('cargo_id', session()->get('profissional_cargo_id'));
        }

        if (trim(session()->get('profissional_vinculo_id')) !== '') {
            $query->where('vinculo_id', session()->get('profissional_vinculo_id'));
        }

        if (trim(session()->get('profissional_vinculo_tipo_id')) !== '') {
            $query->where('vinculo_tipo_id', session()->get('profissional_vinculo_tipo_id'));
        }

        if (trim(session()->get('profissional_carga_horaria_id')) !== '') {
            $query->where('carga_horaria_id', session()->get('profissional_carga_horaria_id'));
        }

        if (trim(session()->get('profissional_flexibilizacao')) !== '') {
            $query->where('flexibilizacao', session()->get('profissional_flexibilizacao'));
        }

        
    }

    /**
     * Cargo do profissional
     *
     * @var Cargo
     */
    public function cargo() : BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Carga horária do profissional
     *
     * @var CargaHoraria
     */
    public function cargaHoraria() : BelongsTo
    {
        return $this->belongsTo(CargaHoraria::class);
    }

    /**
     * Vínculo do profissional
     *
     * @var Vinculo
     */
    public function vinculo() : BelongsTo
    {
        return $this->belongsTo(Vinculo::class);
    }

    /**
     * Tipificação do vínculo do profissional
     *
     * @var VinculoTipo 
     */
    public function vinculoTipo() : BelongsTo
    {
        return $this->belongsTo(VinculoTipo::class);
    }

    /**
     * Orgão Emissor do Registro de classe do profissional
     *
     * @var OrgaoEmissor
     */
    public function orgaoEmissor() : BelongsTo
    {
        return $this->belongsTo(OrgaoEmissor::class);
    }

    /**
     * Férias do profissional
     *
     */
    public function ferias() : HasMany
    {
        return $this->HasMany(Ferias::class);
    }

    /**
     * Licenças do profissional
     */
    public function licencas() : HasMany
    {
        return $this->hasMany(Licenca::class);
    }

    /**
     * capacitações do profissional
     *
     */
    public function capacitacaos() : HasMany
    {
        return $this->HasMany(Capacitacao::class);
    }

    /**
     * Equipes do profissional
     *
     */
    public function equipeProfissionals()
    {
        return $this->hasMany(EquipeProfissional::class);
    }

    /**
     * Históricos do profissional
     *
     */
    public function historicos()
    {
        return $this->hasMany(Historico::class);
    }

}
