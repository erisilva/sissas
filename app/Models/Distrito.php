<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    /**
     * Get all of the unidades for the Distrito
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unidades() : HasMany
    {
        return $this->hasMany(Unidade::class);
    }

    /**
     * The users that belong to the Distrito
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
