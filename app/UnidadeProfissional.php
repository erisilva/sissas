<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeProfissional extends Model
{
    protected $fillable = [
        'descricao', 'unidade_id', 'profissional_id'
    ];

    public function unidade()
    {
        return $this->belongsTo('App\Unidade');
    }

    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }        
}
