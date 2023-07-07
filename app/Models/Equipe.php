<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao', 'numero', 'cnes', 'ine', 'minima', 'unidade_id',
    ];

    /**
     * Unidade da equipe
     *
     * @var Unidade
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Profissionais da equipe
     *
     * @var EquipeProfissional
     */
    public function equipeProfissionals()
    {
        return $this->hasMany(EquipeProfissional::class);
    }

    /**
     * Históricos do profissional
     *
     * @var Historico
     */
    public function historicos()
    {
        return $this->hasMany(Historico::class);
    }
}