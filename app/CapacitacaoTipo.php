<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CapacitacaoTipo extends Model
{
    protected $fillable = [
        'descricao', 
    ];

    /**
     * capacitações do profissional
     *
     * @var Capacitacao
     */
    public function capacitacaos()
    {
        return $this->belongsToMany('App\Capacitacao');
    }
}
