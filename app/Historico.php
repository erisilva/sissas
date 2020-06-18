<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = [
        'observacao', 'historico_tipo_id', 'profissional_id', 'user_id', 'unidade_id', 'equipe_id',
    ];

    protected $dates = ['created_at'];

    public function profissional()
    {
        return $this->belongsTo('App\Profissional')->withTrashed();
    }

    // relação fraca
    public function unidade()
    {
        return $this->belongsTo('App\Unidade');
    }

    // relação fraca
    // testar essa função optional($user->phone)->number;
    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
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
