<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'descricao', 'porte', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'distrito_id'
    ];

    public function distrito()
    {
        return $this->belongsTo('App\Distrito');
    }

    public function equipes()
    {
        return $this->hasMany('App\Equipe');
    }

    public function unidadeProfissionals()
    {
        return $this->hasMany('App\UnidadeProfissional');
    }

    public function historicos()
    {
        return $this->hasMany('App\Historico');
    }
}
