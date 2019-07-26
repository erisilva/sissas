<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipeProfissional extends Model
{
    protected $fillable = [
        'descricao', 'cargo_id', 'equipe_id', 'profissional_id'
    ];

    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }

    // nem toda vaga possui um profissional, chave fraca
    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }
}
