<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'porte', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'distrito_id'
    ];

    /**
     * Get the distrito that owns the Unidade
     *
     */
    public function distrito() : BelongsTo
    {
        return $this->belongsTo(Distrito::class);
    }

    /**
     * Get all of the equipes for the Unidade
     *
     */
    public function equipes()
    {
        return $this->hasMany(Equipe::class);
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
