<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Historico extends Model
{
    use HasFactory;

    protected $fillable = [
        'changes', 'observacao', 'historico_tipo_id', 'profissional_id', 'user_id', 'unidade_id', 'equipe_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
      ];

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

    /**
     * Filtro
     *
     * @return string
     */
    public function scopeFilter($query, array $filters) : void
    {
        // historico_data_inicio
        // historico_data_fim
        // historico_historico_tipo_id
        // historico_nome
        // historico_matricula
        // historico_cpf
        // historico_user_name
        // historico_equipe_descricao
        // historico_ine
        // historico_unidade
        // historico_distrito_id


        // start session values if not yet initialized
        if (!session()->exists('historico_data_inicio')){
            session(['historico_data_inicio' => '']);
        }

        if (!session()->exists('historico_data_fim')){
            session(['historico_data_fim' => '']);
        }

        if (!session()->exists('historico_historico_tipo_id')){
            session(['historico_historico_tipo_id' => '']);
        }

        if (!session()->exists('historico_profissional_id')){
            session(['historico_profissional_id' => '']);
        }

        if (!session()->exists('historico_nome')){
            session(['historico_nome' => '']);
        }

        if (!session()->exists('historico_matricula')){
            session(['historico_matricula' => '']);
        }

        if (!session()->exists('historico_cpf')){
            session(['historico_cpf' => '']);
        }

        if (!session()->exists('historico_user_name')){
            session(['historico_user_name' => '']);
        }

        if (!session()->exists('historico_equipe_descricao')){
            session(['historico_equipe_descricao' => '']);
        }

        if (!session()->exists('historico_ine')){
            session(['historico_ine' => '']);
        }

        if (!session()->exists('historico_unidade')){
            session(['historico_unidade' => '']);
        }

        if (!session()->exists('historico_distrito_id')){
            session(['historico_distrito_id' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'data_inicio')) {
            # covert date to mysql format
            session(['historico_data_inicio' => $filters['data_inicio'] ?? '']);
        }

        if (Arr::exists($filters, 'data_fim')) {
            session(['historico_data_fim' => $filters['data_fim'] ?? '']);
        }

        if (Arr::exists($filters, 'historico_tipo_id')) {
            session(['historico_historico_tipo_id' => $filters['historico_tipo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'nome')) {
            session(['historico_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'matricula')) {
            session(['historico_matricula' => $filters['matricula'] ?? '']);
        }

        if (Arr::exists($filters, 'cpf')) {
            session(['historico_cpf' => $filters['cpf'] ?? '']);
        }

        if (Arr::exists($filters, 'user_name')) {
            session(['historico_user_name' => $filters['user_name'] ?? '']);
        }

        if (Arr::exists($filters, 'equipe_descricao')) {
            session(['historico_equipe_descricao' => $filters['equipe_descricao'] ?? '']);
        }

        if (Arr::exists($filters, 'ine')) {
            session(['historico_ine' => $filters['ine'] ?? '']);
        }

        if (Arr::exists($filters, 'unidade')) {
            session(['historico_unidade' => $filters['unidade'] ?? '']);
        }

        if (Arr::exists($filters, 'distrito_id')) {
            session(['historico_distrito_id' => $filters['distrito_id'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('historico_data_inicio')) !== '') {
            $query->where('historicos.created_at', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', session()->get('historico_data_inicio')))));
        }

        if (trim(session()->get('historico_data_fim')) !== '') {
            $query->where('historicos.created_at', '<=', date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', session()->get('historico_data_fim')))));
        }

        if (trim(session()->get('historico_historico_tipo_id')) !== '') {
            $query->where('historico_tipo_id', session()->get('historico_historico_tipo_id'));
        }

        if (trim(session()->get('historico_nome')) !== '') {
            $query->whereHas('profissional', function ($query) {
                $query->where('nome', 'like', '%' . session()->get('historico_nome') . '%');
            });
        }

        if (trim(session()->get('historico_matricula')) !== '') {
            $query->whereHas('profissional', function ($query) {
                $query->where('matricula', 'like', '%' . session()->get('historico_matricula') . '%');
            });
        }

        if (trim(session()->get('historico_cpf')) !== '') {
            $query->whereHas('profissional', function ($query) {
                $query->where('cpf', 'like', '%' . session()->get('historico_cpf') . '%');
            });
        }

        if (trim(session()->get('historico_user_name')) !== '') {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . session()->get('historico_user_name') . '%');
            });
        }

        if (trim(session()->get('historico_equipe_descricao')) !== '') {
            $query->whereHas('equipe', function ($query) {
                $query->where('descricao', 'like', '%' . session()->get('historico_equipe_descricao') . '%');
            });
        }

        if (trim(session()->get('historico_ine')) !== '') {
            $query->whereHas('equipe', function ($query) {
                $query->where('ine', 'like', '%' . session()->get('historico_ine') . '%');
            });
        }

        if (trim(session()->get('historico_unidade')) !== '') {
            $query->whereHas('unidade', function ($query) {
                $query->where('descricao', 'like', '%' . session()->get('historico_unidade') . '%');
            });
        }

        if (trim(session()->get('historico_distrito_id')) !== '') {
            $query->whereHas('unidade', function ($query) {
                $query->where('distrito_id', session()->get('historico_distrito_id'));
            });
        }

    }    
}
