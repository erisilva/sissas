<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao', 
    ];

    /**
     * Histórico dos profissionais
     *
     */
    public function historicos()
    {
        return $this->belongsToMany(Historico::class);
    }
}
