<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;

    protected $fillable = [
        'changes', 'historico_tipo_id', 'profissional_id', 'user_id', 'unidade_id', 'equipe_id',
    ];

    protected $dates = ['created_at'];

    /**
     * Profissional do histórico
     *
     * @var Profissional
     */
    public function profissional()
    {
        return $this->belongsTo(Profissional::class)->withTrashed();
    }

    /**
     * Unidade do histórico
     *
     * @var Unidade - weak key
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Equipe do histórico
     *
     * @var Equipe - weak key
     */
    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    /**
     * Tipo do histórico
     *
     * @var HistoricoTipo
     */
    public function historicoTipo()
    {
        return $this->belongsTo(HistoricoTipo::class);
    }

    /**
     * Usuário do histórico
     *
     * @var User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
