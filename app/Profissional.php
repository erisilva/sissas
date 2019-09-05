<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
	// o softDeletes será usado como arquivo morto pelo sistema
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'matricula', 'cns', 'cpf', 'flexibilizacao', 'admissao', 'observacao', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cargo_id', 'carga_horaria_id', 'vinculo_id', 'vinculo_tipo_id', 'orgao_emissor_id', 'registroClasse', 'ufOrgaoEmissor'
    ];

    /**
     * Cargo do profissional
     *
     * @var Cargo
     */
    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    /**
     * Carga horária do profissional
     *
     * @var CargaHoraria
     */
    public function cargaHoraria()
    {
        return $this->belongsTo('App\CargaHoraria');
    }

    /**
     * Vínculo do profissional
     *
     * @var Vinculo
     */
    public function vinculo()
    {
        return $this->belongsTo('App\Vinculo');
    }

    /**
     * Tipificação do vínculo do profissional
     *
     * @var VinculoTipo
     */
    public function vinculoTipo()
    {
        return $this->belongsTo('App\VinculoTipo');
    }

    /**
     * Orgão Emissor do Registro de classe do profissional
     *
     * @var VinculoTipo
     */
    public function orgaoEmissor()
    {
        return $this->belongsTo('App\OrgaoEmissor');
    }

    /**
     * Férias do profissional
     *
     * @var Ferias
     */
    public function ferias()
    {
        return $this->belongsToMany('App\Ferias');
    }

    /**
     * Licenças do profissional
     *
     * @var Licencas
     */
    public function licencas()
    {
        return $this->belongsToMany('App\Licenca');
    }

    /**
     * capacitações do profissional
     *
     * @var Capacitacao
     */
    public function capacitacaos()
    {
        return $this->belongsToMany('App\Capacitacao');
    }

    /**
     * Cadastro de determinados profissionais diretamente na unidade
     * exemplo: equipe de limpeza, atendente, vigias, etc
     *
     * @var UnidadeProfissional
     */
    public function unidadeProfissionals()
    {
        return $this->hasMany('App\UnidadeProfissional');
    }

    /**
     * Vagas (cargo e profissional) de cada equipe
     *
     * @var UnidadeProfissional
     */
    public function equipeProfissionals()
    {
        return $this->hasMany('App\EquipeProfissional');
    }

    /**
     * Histórico dos profissionais
     *
     * @var Licencas
     */
    public function historicos()
    {
        return $this->belongsToMany('App\Historico');
    }

    protected $dates = ['deleted_at', 'admissao'];
}
