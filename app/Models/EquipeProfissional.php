<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeProfissional extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao', 'cargo_id', 'equipe_id', 'profissional_id'
    ];

    /**
     * Cargo do profissional
     *
     * @var Cargo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Equipe do profissional
     *
     * @var Equipe
     */
    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    /**
     * Profissional da equipe
     *
     * @var Profissional
     */
    // nem toda vaga possui um profissional, chave fraca
    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }
}
