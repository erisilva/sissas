<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeriasTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
    ];

    /**
     * Férias do profissional
     *
     * @var Ferias
     */
    public function ferias() : HasMany
    {
        return $this->hasMany(Ferias::class);
    } 
}
