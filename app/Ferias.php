<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ferias extends Model
{
    protected $fillable = [
        'inicio', 'fim', 'justificativa', 'observacao', 'ferias_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $dates = ['inicio', 'fim'];

    public function profissional()
    {
        return $this->belongsTo('App\profissional');
    }

    public function feriasTipo()
    {
        return $this->belongsTo('App\FeriasTipo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
