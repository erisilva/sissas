<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoTipo extends Model
{
    protected $fillable = [
        'descricao', 
    ];

    /**
     * Histórico dos profissionais
     *
     * @var Licencas
     */
    public function historicos()
    {
        return $this->belongsToMany('App\Historico');
    }
}
