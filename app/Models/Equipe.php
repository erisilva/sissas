<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builderinner_;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao', 'numero', 'cnes', 'ine', 'minima', 'unidade_id', 'equipe_tipo_id'
    ];

    /**
     * Unidade da equipe
     *
     * @var Unidade
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Tipo da equipe
     *
     * @var EquipeTipo
     */
    public function equipeTipo()
    {
        return $this->belongsTo(EquipeTipo::class);
    }

    /**
     * Profissionais da equipe
     *
     * @var EquipeProfissional
     */
    public function equipeProfissionals()
    {
        return $this->hasMany(EquipeProfissional::class);
    }

    /**
     * Históricos do profissional
     *
     * @var Historico
     */
    public function historicos()
    {
        return $this->hasMany(Historico::class);
    }

    /**
     * Filter users by name or email
     *
     */
    public function scopeFilter($query, array $filters) : void
    {
        // showing only the distritos that the user has access to
        $query = $query->whereHas('unidade', function ($inner_query) {
            $inner_query->whereHas('distrito', function ($inner_query) {
                $inner_query->whereIn('distritos.id', auth()->user()->distritos->pluck('id'));
            });
        });

        // start session values if not yet initialized
        if (!session()->exists('equipe_descricao')){
            session(['equipe_descricao' => '']);
        }
        if (!session()->exists('equipe_numero')){
            session(['equipe_numero' => '']);
        }
        if (!session()->exists('equipe_cnes')){
            session(['equipe_cnes' => '']);
        }
        if (!session()->exists('equipe_ine')){
            session(['equipe_ine' => '']);
        }
        if (!session()->exists('equipe_minima')){
            session(['equipe_minima' => '']);
        }
        if (!session()->exists('equipe_unidade')){
            session(['equipe_unidade' => '']);
        }
        if (!session()->exists('equipe_distrito')){
            session(['equipe_distrito' => '']);
        }
        if (!session()->exists('equipe_tipo')){
            session(['equipe_tipo' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'descricao')) {
            session(['equipe_descricao' => $filters['descricao'] ?? '']);
        }

        if (Arr::exists($filters, 'numero')) {
            session(['equipe_numero' => $filters['numero'] ?? '']);
        }

        if (Arr::exists($filters, 'cnes')) {
            session(['equipe_cnes' => $filters['cnes'] ?? '']);
        }

        if (Arr::exists($filters, 'ine')) {
            session(['equipe_ine' => $filters['ine'] ?? '']);
        }

        if (Arr::exists($filters, 'minima')) {
            session(['equipe_minima' => $filters['minima'] ?? '']);
        }

        if (Arr::exists($filters, 'unidade')) {
            session(['equipe_unidade' => $filters['unidade'] ?? '']);
        }

        if (Arr::exists($filters, 'distrito')) {
            session(['equipe_distrito' => $filters['distrito'] ?? '']);
        }

        if (Arr::exists($filters, 'tipo')) {
            session(['equipe_tipo' => $filters['tipo'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('equipe_descricao')) !== '') {
            $query->where('equipes.descricao', 'like', '%' . session()->get('equipe_descricao') . '%');
        }

        if (trim(session()->get('equipe_numero')) !== '') {
            $query->where('equipes.numero', 'like', '%' . session()->get('equipe_numero') . '%');
        }

        if (trim(session()->get('equipe_cnes')) !== '') {
            $query->where('equipes.cnes', 'like', '%' . session()->get('equipe_cnes') . '%');
        }

        if (trim(session()->get('equipe_ine')) !== '') {
            $query->where('equipes.ine', 'like', '%' . session()->get('equipe_ine') . '%');
        }

        if (trim(session()->get('equipe_minima')) !== '') {
            $query->where('equipes.minima', 'like', '%' . session()->get('equipe_minima') . '%');
        }

        if (trim(session()->get('equipe_unidade')) !== '') {
            $query = $query->whereHas('unidade', function ($inner_query) {
                $inner_query->where('unidades.nome', 'like', '%' . session()->get('equipe_unidade') . '%');
            });
        }

        if (trim(session()->get('equipe_distrito')) !== '') {
            $query = $query->whereHas('unidade', function ($inner_query) {
                $inner_query->whereHas('distrito', function ($inner_query) {
                    $inner_query->where('distritos.id', session()->get('equipe_distrito'));
                });
            });
        }

        if (trim(session()->get('equipe_tipo')) !== '') {
            $query->where('equipes.equipe_tipo_id', session()->get('equipe_tipo'));
        }

        // filtrar para mstrar apenas as equiped dos distritos em que o usuário logado tem permissão
        // if (auth()->user()->can('distrito')) {
        //     $query = $query->whereHas('unidade', function ($inner_query) {
        //         $inner_query->whereHas('distrito', function ($inner_query) {
        //             $inner_query->whereIn('distritos.id', auth()->user()->distritos->pluck('id'));
        //         });
        //     });
        // }

        // testar


    }

    /**
     * Calcula a quantidade de vagas da equipe.
     *
     */
    public function getTotalVagasAttribute(){
        return $this->equipeProfissionals->count();
    }
  
    /**
     * Calcula a quantidade de vagas preenchidas da equipe.
     *
     */
    public function getVagasPreenchidasAttribute(){
        return (int) $this->equipeProfissionals->whereNotNull('profissional_id')->count();
    }

    /**
     * Calcula a quantidade de vagas disponíveis da equipe.
     *
     */
    public function getVagasDisponiveisAttribute(){
        return (int) $this->equipeProfissionals->whereNull('profissional_id')->count();
    }
        
}
