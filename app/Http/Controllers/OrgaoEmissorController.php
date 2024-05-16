<?php

namespace App\Http\Controllers;

use App\Models\OrgaoEmissor;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\OrgaoEmissorsExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class OrgaoEmissorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('orgaoemissor.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('orgaoemissors.index', [
            'orgaoemissors' => OrgaoEmissor::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/orgaoemissors'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('orgaoemissor.create');

        return view('orgaoemissors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('orgaoemissor.create');

        $orgaoemissor = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        OrgaoEmissor::create($orgaoemissor);

        return redirect(route('orgaoemissors.index'))->with('message', 'Orgao Emissor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrgaoEmissor $orgaoemissor) : View
    {
        $this->authorize('orgaoemissor.show');

        return view('orgaoemissors.show', [
            'orgaoemissor' => $orgaoemissor
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrgaoEmissor $orgaoemissor) : View
    {
        $this->authorize('orgaoemissor.edit');

        return view('orgaoemissors.edit', [
          'orgaoemissor' => $orgaoemissor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgaoEmissor $orgaoemissor) : RedirectResponse
    {
        $this->authorize('orgaoemissor.edit');
  
        $orgaoemissor->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('orgaoemissors.index'))->with('message', 'Orgao Emissor alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgaoEmissor $orgaoemissor)  : RedirectResponse
    {
        $this->authorize('orgaoemissor.delete');
     
        DB::beginTransaction();   
        try {
  
            $orgaoemissor->delete();

            DB::commit();
  
            return redirect(route('orgaoemissors.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('orgaoemissors.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('orgaoemissor.export');

        return Pdf::loadView('orgaoemissors.report', [
            'dataset' => OrgaoEmissor::orderBy('nome', 'asc')->get()
        ])->download('OrgaoEmissor_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('orgaoemissor.export');

        return Excel::download(new OrgaoEmissorsExport(), 'OrgaoEmissor_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('orgaoemissor.export');

        return Excel::download(new OrgaoEmissorsExport(), 'OrgaoEmissor_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
