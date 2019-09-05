<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = [
        'observacao', 'historico_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $dates = ['created_at'];

    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }

    public function historicoTipo()
    {
        return $this->belongsTo('App\HistoricoTipo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
