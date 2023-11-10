<?php

namespace App\Http\Controllers;

use App\Models\EquipeTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\EquipeTiposExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class EquipeTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('equipetipo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('equipetipos.index', [
            'equipetipos' => EquipeTipo::orderBy('nome', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('equipetipo.create');

        return view('equipetipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('equipetipo.create');

        $equipetipo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        EquipeTipo::create($equipetipo);

        return redirect(route('equipetipos.index'))->with('message', 'Tipo de equipe criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipeTipo $equipetipo)
    {
        $this->authorize('equipetipo.show');

        return view('equipetipos.show', [
            'equipetipo' => $equipetipo
            ]
        );

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipeTipo $equipeTipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EquipeTipo $equipeTipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipeTipo $equipeTipo)
    {
        //
    }
}
