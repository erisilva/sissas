<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeriasTipo extends Model
{
    protected $fillable = [
        'descricao', 
    ];

/**
     * Férias do profissional
     *
     * @var Ferias
     */
    public function ferias()
    {
        return $this->belongsToMany('App\Ferias');
    }    
}
