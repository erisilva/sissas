<?php

namespace App\Http\Controllers;

use App\Models\CargaHoraria;
use App\Models\Perpage;

use Illuminate\Http\Request;

class CargaHorariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('cargahoraria.index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('cargahoraria.index', [
            'cargahorarias' => CargaHoraria::orderBy('nome', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CargaHoraria $cargaHoraria)
    {
        //
    }
}
