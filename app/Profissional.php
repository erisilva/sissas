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
        'nome', 'matricula', 'cns', 'cpf', 'flexibilizacao', 'admissao', 'observacao', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cargo_id', 'carga_horaria_id', 'vinculo_id', 'vinculo_tipo_id'
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

    protected $dates = ['deleted_at', 'admissao'];
}
