<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Licenca extends Model
{
    use HasFactory;

    protected $fillable = [
        'inicio', 'fim', 'observacao', 'licenca_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $dates = ['inicio', 'fim'];

    public function profissional() : BelongsTo
    {
        return $this->belongsTo(Profissional::class);
    }

    public function licencaTipo() : BelongsTo
    {
        return $this->belongsTo(LicencaTipo::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }  
}
