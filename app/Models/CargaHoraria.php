<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class CargaHoraria extends Model
{
    use HasFactory;

    protected $fillable = [
        'mome'
    ];

    public function profissionals() : hasMany
    {
        return $this->hasMany(Profissional::class);
    }
}