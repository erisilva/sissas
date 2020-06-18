<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
	use SoftDeletes;

    protected $fillable = [
		'descricao', 'numero', 'cnes', 'ine', 'minima', 'unidade_id',
    ];

    protected $dates = ['deleted_at'];

    public function unidade()
    {
        return $this->belongsTo('App\Unidade');
    }

    public function equipeProfissionals()
    {
        return $this->hasMany('App\EquipeProfissional');
    }

    public function historicos()
    {
        return $this->hasMany('App\Historico');
    }
}
