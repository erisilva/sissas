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
}
