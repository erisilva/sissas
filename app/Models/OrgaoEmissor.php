<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class OrgaoEmissor extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    public function profissionals() : hasMany
    {
        return $this->hasMany(Profissional::class);
    }
}
