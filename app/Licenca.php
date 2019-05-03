<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licenca extends Model
{
    protected $fillable = [
        'inicio', 'fim', 'observacao', 'licenca_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $dates = ['inicio', 'fim'];

    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }

    public function licencaTipo()
    {
        return $this->belongsTo('App\LicencaTipo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
