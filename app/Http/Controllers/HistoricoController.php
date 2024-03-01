<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\HistoricoTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('historico.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('historicos.index', [
            'historicos' => Historico::orderBy('id', 'desc')->filter(request(['name', 'description']))->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('historico-export');

        // return Pdf::loadView('permissions.report', [
        //     'dataset' => Permission::orderBy('id', 'asc')->filter(request(['name', 'description']))->get()
        // ])->download(__('Permissions') . '_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('historico-export');

        //return Excel::download(new PermissionsExport(request(['name', 'description'])),  __('Permissions') . '_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('historico-export');

        //return Excel::download(new PermissionsExport(request(['name', 'description'])),  __('Permissions') . '_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
