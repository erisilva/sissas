<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cbo'
    ];

    public function profissionals() : hasMany
    {
        return $this->hasMany(Profissional::class);
    }
}
