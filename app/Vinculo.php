<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    protected $fillable = [
        'descricao', 
    ];

    public function profissionals()
    {
        return $this->hasMany('App\Profissional');
    }
}
