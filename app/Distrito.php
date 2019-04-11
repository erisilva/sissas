<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = [
        'nome', 
    ];

    public function unidades()
    {
        return $this->belongsToMany('App\Unidade');
    }

     /**
     * Operadores com acesso as equipes desse(s) distrito(s) 
     *
     * @var User
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
