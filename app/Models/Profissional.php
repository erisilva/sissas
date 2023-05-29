<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 'matricula', 'cns', 'cpf', 'flexibilizacao', 'admissao', 'observacao', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cargo_id', 'carga_horaria_id', 'vinculo_id', 'vinculo_tipo_id', 'orgao_emissor_id', 'registroClasse', 'ufOrgaoEmissor'
    ];

    protected $dates = ['deleted_at', 'admissao']; 

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

}
