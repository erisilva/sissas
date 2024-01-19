<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EquipeView extends Model
{
    use HasFactory;

    /**
     * Filter users by name or email
     *
     */
    public function scopeFilter($query, array $filters) : void
    {
        
        // showing only the distritos that the user has access to
        $query->whereIn('distrito_id', auth()->user()->distritos->pluck('id'));

        // start session values if not yet initialized
        if (!session()->exists('equipe_view_nome')){
            session(['equipe_view_nome' => '']);
        }

        if (!session()->exists('equipe_view_matricula')){
            session(['equipe_view_matricula' => '']);
        }

        if (!session()->exists('equipe_view_cpf')){
            session(['equipe_view_cpf' => '']);
        }

        if (!session()->exists('equipe_view_cargo_id')){
            session(['equipe_view_cargo_id' => '']);
        }

        if (!session()->exists('equipe_view_vinculo_id')){
            session(['equipe_view_vinculo_id' => '']);
        }

        if (!session()->exists('equipe_view_vinculo_tipo_id')){
            session(['equipe_view_vinculo_tipo_id' => '']);
        }

        if (!session()->exists('equipe_view_equipe')){
            session(['equipe_view_equipe' => '']);
        }

        if (!session()->exists('equipe_view_equipe_tipo_id')){
            session(['equipe_view_equipe_tipo_id' => '']);
        }

        if (!session()->exists('equipe_view_numero')){
            session(['equipe_view_numero' => '']);
        }

        if (!session()->exists('equipe_view_cnes')){
            session(['equipe_view_cnes' => '']);
        }

        if (!session()->exists('equipe_view_ine')){
            session(['equipe_view_ine' => '']);
        }

        if (!session()->exists('equipe_view_unidade')){
            session(['equipe_view_unidade' => '']);
        }

        if (!session()->exists('equipe_view_distrito_id')){
            session(['equipe_view_distrito_id' => '']);
        }

        if (!session()->exists('equipe_view_mostrar_vagas')){
            session(['equipe_view_mostrar_vagas' => '']);
        }

        // update session values if the request has a value

        if (Arr::exists($filters, 'nome')) {
            session(['equipe_view_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'matricula')) {
            session(['equipe_view_matricula' => $filters['matricula'] ?? '']);
        }

        if (Arr::exists($filters, 'cpf')) {
            session(['equipe_view_cpf' => $filters['cpf'] ?? '']);
        }

        if (Arr::exists($filters, 'cargo_id')) {
            session(['equipe_view_cargo_id' => $filters['cargo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'vinculo_id')) {
            session(['equipe_view_vinculo_id' => $filters['vinculo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'vinculo_tipo_id')) {
            session(['equipe_view_vinculo_tipo_id' => $filters['vinculo_tipo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'equipe')) {
            session(['equipe_view_equipe' => $filters['equipe'] ?? '']);
        }

        if (Arr::exists($filters, 'equipe_tipo_id')) {
            session(['equipe_view_equipe_tipo_id' => $filters['equipe_tipo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'numero')) {
            session(['equipe_view_numero' => $filters['numero'] ?? '']);
        }

        if (Arr::exists($filters, 'cnes')) {
            session(['equipe_view_cnes' => $filters['cnes'] ?? '']);
        }

        if (Arr::exists($filters, 'ine')) {
            session(['equipe_view_ine' => $filters['ine'] ?? '']);
        }

        if (Arr::exists($filters, 'unidade')) {
            session(['equipe_view_unidade' => $filters['unidade'] ?? '']);
        }

        if (Arr::exists($filters, 'distrito_id')) {
            session(['equipe_view_distrito_id' => $filters['distrito_id'] ?? '']);
        }

        if (Arr::exists($filters, 'mostrar_vagas')) {
            session(['equipe_view_mostrar_vagas' => $filters['mostrar_vagas'] ?? '1']);
        }

        // filter the query

        if (trim(session()->get('equipe_view_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('equipe_view_nome') . '%');
        }

        if (trim(session()->get('equipe_view_matricula')) !== '') {
            $query->where('matricula', 'like', '%' . session()->get('equipe_view_matricula') . '%');
        }

        if (trim(session()->get('equipe_view_cpf')) !== '') {
            $query->where('cpf', 'like', '%' . session()->get('equipe_view_cpf') . '%');
        }

        if (trim(session()->get('equipe_view_cargo_id')) !== '') {
            $query->where('cargo_equipe_id', session()->get('equipe_view_cargo_id'));
        }

        if (trim(session()->get('equipe_view_vinculo_id')) !== '') {
            $query->where('vinculo_id', session()->get('equipe_view_vinculo_id'));
        }

        if (trim(session()->get('equipe_view_vinculo_tipo_id')) !== '') {
            $query->where('vinculo_tipo_id', session()->get('equipe_view_vinculo_tipo_id'));
        }

        if (trim(session()->get('equipe_view_equipe')) !== '') {
            $query->where('equipe', 'like', '%' . session()->get('equipe_view_equipe') . '%');
        }

        if (trim(session()->get('equipe_view_equipe_tipo_id')) !== '') {
            $query->where('equipe_tipo_id', session()->get('equipe_view_equipe_tipo_id'));
        }

        if (trim(session()->get('equipe_view_numero')) !== '') {
            $query->where('equipe_numero', 'like', '%' .  session()->get('equipe_view_numero') . '%');
        }

        if (trim(session()->get('equipe_view_cnes')) !== '') {
            $query->where('cnes', 'like', '%' . session()->get('equipe_view_cnes') . '%');
        }

        if (trim(session()->get('equipe_view_ine')) !== '') {
            $query->where('ine', 'like', '%' . session()->get('equipe_view_ine') . '%');
        }

        if (trim(session()->get('equipe_view_unidade')) !== '') {
            $query->where('unidade', 'like', '%' . session()->get('equipe_view_unidade') . '%');
        }

        if (trim(session()->get('equipe_view_distrito_id')) !== '') {
            $query->where('distrito_id', session()->get('equipe_view_distrito_id'));
        }

        if (trim(session()->get('equipe_view_mostrar_vagas')) !== '') {
            if (session()->get('equipe_view_mostrar_vagas') == '1') {
                // todas
            } elseif (session()->get('equipe_view_mostrar_vagas') == '2') {
                // somente vagas
                $query->whereNull('profissional_id');
            } elseif (session()->get('equipe_view_mostrar_vagas') == '3') {
                // somente ocupadas
                $query->whereNotNull('profissional_id');
            }
        }

        

    }    
}
