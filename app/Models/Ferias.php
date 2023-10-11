<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Builder;

class Ferias extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'inicio', 'fim', 'justificativa', 'observacao', 'ferias_tipo_id', 'profissional_id', 'user_id'
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fim' => 'datetime',
      ];

    public function profissional() : BelongsTo
    {
        return $this->belongsTo(Profissional::class);
    }

    public function feriasTipo() : BelongsTo
    {
        return $this->belongsTo(FeriasTipo::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filter
     * data_inicio
     * data_fim
     * profissional
     * ferias_tipo_id
     */
    public function scopeFilter($query, array $filters) : void
    {
        // start session values if not yet initialized
        if (!session()->exists('ferias_data_inicio')){
            session(['ferias_data_inicio' => '']);
        }
        if (!session()->exists('ferias_data_fim')){
            session(['ferias_data_fim' => '']);
        }
        if (!session()->exists('ferias_profissional')){
            session(['ferias_profissional' => '']);
        }
        if (!session()->exists('ferias_ferias_tipo_id')){
            session(['ferias_ferias_tipo_id' => '']);
        }

        // update session values if the request has a value
        // the filter session dont format the date to mysql, is used the dd/mm/yyyy format
        if (Arr::exists($filters, 'data_inicio')) {
            # the data_inicio need to be in mysql format (Y-m-d)
            session(['ferias_data_inicio' => $filters['data_inicio'] ?? '']);
            
            # verify if data_inicio  is validcdate, before processing
            // if (strtotime(str_replace('/', '-', $filters['data_inicio'])) !== false) {
            //     session(['ferias_data_inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $filters['data_inicio'])))]);
            // }


            // session(['ferias_data_inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $filters['data_inicio'])))]);
        }
        if (Arr::exists($filters, 'data_fim')) {
            session(['ferias_data_fim' => $filters['data_fim'] ?? '']);
        }
        if (Arr::exists($filters, 'profissional')) {
            session(['ferias_profissional' => $filters['profissional'] ?? '']);
        }
        if (Arr::exists($filters, 'ferias_tipo_id')) {
            session(['ferias_ferias_tipo_id' => $filters['ferias_tipo_id'] ?? '']);
        }

        // verificação de interpolação entre dois períodos
        // (StartDate1 <= EndDate2) and (StartDate2 <= EndDate1)
                // (StartDate1 <= EndDate2) and (EndDate1 >= StartDate2)
                // (StartA <= EndB) and (EndA >= StartB)
                // StartDate1 = inicio
                // EndDate1 = fim
                // StartDate2 = dtainicio
                // EndDate2 = dtafinal

        // query if session filters are not empty
        // the filter has to have both dates for overlaping
        if (trim(session()->get('ferias_data_inicio')) !== '' && trim(session()->get('ferias_data_fim')) !== '') {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('inicio', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_inicio')))))
                          ->where('inicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('fim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_inicio')))))
                          ->where('fim', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('inicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_inicio')))))
                          ->where('fim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('ferias_data_fim')))));
                });
            });
        }

        if (trim(session()->get('ferias_profissional')) !== '') {
            $query->whereHas('profissional', function ($query) {
                $query->where('nome', 'like', '%' . session()->get('ferias_profissional') . '%');
            });
        }

        if (trim(session()->get('ferias_ferias_tipo_id')) !== '') {
            $query->where('ferias_tipo_id', session()->get('ferias_ferias_tipo_id'));
        }

    }
       
}
