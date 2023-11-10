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
        if (!session()->exists('profissional_cargo_id')){
            session(['profissional_cargo_id' => '']);
        }
        if (!session()->exists('profissional_vinculo_id')){
            session(['profissional_vinculo_id' => '']);
        }
        if (!session()->exists('profissional_matricula')){
            session(['profissional_matricula' => '']);
        }
        
        

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['profissional_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'cargo_id')) {
            session(['profissional_cargo_id' => $filters['cargo_id'] ?? '']);
        }
        
        if (Arr::exists($filters, 'vinculo_id')) {
            session(['profissional_vinculo_id' => $filters['vinculo_id'] ?? '']);
        }
        
        if (Arr::exists($filters, 'matricula')) {
            session(['profissional_matricula' => $filters['matricula'] ?? '']);
        }
        
        // query if session filters are not empty
        if (trim(session()->get('profissional_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('profissional_nome') . '%');
        }

        if (trim(session()->get('profissional_cargo_id')) !== '') {
            $query->where('cargo_id', session()->get('profissional_cargo_id'));
        }

        if (trim(session()->get('profissional_vinculo_id')) !== '') {
            $query->where('vinculo_id', session()->get('profissional_vinculo_id'));
        }

        if (trim(session()->get('profissional_matricula')) !== '') {
            $query->where('matricula', 'like', '%' . session()->get('profissional_matricula') . '%');
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
     * @var Ferias
     */
    public function ferias() : HasMany
    {
        return $this->HasMany(Ferias::class);
    }

    /**
     * Licenças do profissional
     *
     * @var Licencas
     */
    public function licencas() : HasMany
    {
        return $this->hasMany(Licenca::class);
    }

    /**
     * capacitações do profissional
     *
     * @var Capacitacao
     */
    public function capacitacaos() : HasMany
    {
        return $this->HasMany(Capacitacao::class);
    }

    /**
     * Equipes do profissional
     *
     * @var EquipeProfissional
     */
    public function equipeProfissionals()
    {
        return $this->hasMany(EquipeProfissional::class);
    }

    /**
     * Históricos do profissional
     *
     * @var Historico
     */
    public function historicos()
    {
        return $this->hasMany(Historico::class);
    }

}
