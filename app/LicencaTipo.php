<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicencaTipo extends Model
{
    protected $fillable = [
        'descricao', 
    ];

    /**
     * Licenças do profissional
     *
     * @var Licencas
     */
    public function licencas()
    {
        return $this->belongsToMany('App\Licenca');
    }
    
}
