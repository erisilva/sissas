<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeView extends Model
{
    use HasFactory;

    /**
     * Filter users by name or email
     *
     */
    public function scopeFilter($query, array $filters) : void
    {

    }    
}
