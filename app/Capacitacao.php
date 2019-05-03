<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capacitacao extends Model
{
    protected $fillable = [
        'inicio', 'fim', 'cargaHoraria', 'observacao', 'capacitacao_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $dates = ['inicio', 'fim'];


    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }

    public function capacitacaoTipo()
    {
        return $this->belongsTo('App\CapacitacaoTipo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
