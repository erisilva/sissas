<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Capacitacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'inicio', 'fim', 'cargaHoraria', 'observacao', 'capacitacao_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fim' => 'datetime',
    ];
    
    public function profissional() : BelongsTo
    {
        return $this->belongsTo(Profissional::class);
    }

    public function capacitacaoTipo() : BelongsTo
    {
        return $this->belongsTo(CapacitacaoTipo::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
