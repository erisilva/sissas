<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Arr;

class Unidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'porte', 'tel', 'cel', 'email', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'distrito_id'
    ];

    /**
     * Filter
     *
     */
    public function scopeFilter($query, array $filters) : void
    {
        // start session values if not yet initialized
        if (!session()->exists('unidade_nome')){
            session(['unidade_nome' => '']);
        }
        if (!session()->exists('unidade_distrito_id')){
            session(['unidade_distrito_id' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['unidade_nome' => $filters['nome'] ?? '']);
        }
        
        if (Arr::exists($filters, 'distrito_id')) {
            session(['unidade_distrito_id' => $filters['distrito_id'] ?? '']);
        }
        
        // query if session filters are not empty
        if (trim(session()->get('unidade_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('unidade_nome') . '%');
        }

        if (trim(session()->get('unidade_distrito_id')) !== '') {
            $query->where('distrito_id', session()->get('unidade_distrito_id'));
        }
    }

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
