<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ferias extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'inicio', 'fim', 'justificativa', 'observacao', 'ferias_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fim' => 'datetime',
      ];

    public function profissional() : BelongsTo
    {
        return $this->belongsTo(Profissional::class);
    }

    public function feriasTipo() : BelongsTo
    {
        return $this->belongsTo(FeriasTipo::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filter
     *
     */
    public function scopeFilter($query, array $filters) : void
    {

    }
       
}
