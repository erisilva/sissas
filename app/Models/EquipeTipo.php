<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
    ];

    /**
     * Equipes do tipo
     *
     * @var Equipe
     */
    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
   
}
