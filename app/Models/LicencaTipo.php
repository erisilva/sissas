<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LicencaTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

        /**
     * Licenças do profissional
     *
     */
    public function licencas() : HasMany
    {
        return $this->hasMany(Licenca::class);
    }
}
