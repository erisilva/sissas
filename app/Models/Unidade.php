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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distrito() : BelongsTo
    {
        return $this->belongsTo(Distrito::class);
    }
}
