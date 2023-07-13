<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Vinculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function profissionals() : hasMany
    {
        return $this->hasMany(Profissional::class);
    }
}
