<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'nome', 'cbo'
    ];

    public function profissionals()
    {
        return $this->hasMany('App\Profissional');
    }

    public function equipeProfissionals()
    {
        return $this->hasMany('App\EquipeProfissional');
    }
}
