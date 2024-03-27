<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Auth;

# Controllers
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CargaHorariaController;
use App\Http\Controllers\VinculoController;
use App\Http\Controllers\LicencaTipoController;
use App\Http\Controllers\FeriasTipoController;
use App\Http\Controllers\CapacitacaoTipoController;
use App\Http\Controllers\OrgaoEmissorController;
use App\Http\Controllers\VinculoTipoController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\FeriasController;
use App\Http\Controllers\LicencaController;
use App\Http\Controllers\ProfissionalFeriasController;
use App\Http\Controllers\ProfissionalLicencaController;
use App\Http\Controllers\ProfissionalCapacitacaoController;
use App\Http\Controllers\EquipeTipoController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\EquipeVagasController;
use App\Http\Controllers\EquipeGestaoController;
use App\Http\Controllers\EquipeViewController;
use App\Http\Controllers\ProfissionalTrashController;
use App\Http\Controllers\historicoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# about page
Route::get('/about', function () {
    return view('about.about');
})->name('about')->middleware('auth', 'verified');

Route::get('/', function () {
    #if the user is logged return index view, if not logged return login view
    if (Auth::check()) {
        return view('index');
    } else {
        return view('auth.login');
    }
});

# add 'register' => false to Auth::routes() to disable registration
Auth::routes(['verify' => true]);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth', 'verified');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth', 'verified');
Route::post('/profile/update/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update')->middleware('auth', 'verified');

# Permission::class

Route::get('/permissions/export/csv', [PermissionController::class, 'exportcsv'])->name('permissions.export.csv')->middleware('auth', 'verified');

Route::get('/permissions/export/xls', [PermissionController::class, 'exportxls'])->name('permissions.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/permissions/export/pdf', [PermissionController::class, 'exportpdf'])->name('permissions.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/permissions', PermissionController::class)->middleware(['auth', 'verified']); // Resource Route, crud

# Role::class

Route::get('/roles/export/csv', [RoleController::class, 'exportcsv'])->name('roles.export.csv')->middleware('auth', 'verified'); // Export CSV

Route::get('/roles/export/xls', [RoleController::class, 'exportxls'])->name('roles.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/roles/export/pdf', [RoleController::class, 'exportpdf'])->name('roles.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/roles', RoleController::class)->middleware(['auth', 'verified']); // Resource Route, crud

# User::class

Route::get('/users/export/csv', [UserController::class, 'exportcsv'])->name('users.export.csv')->middleware('auth', 'verified'); // Export CSV

Route::get('/users/export/xls', [UserController::class, 'exportxls'])->name('users.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/users/export/pdf', [UserController::class, 'exportpdf'])->name('users.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/users', UserController::class)->middleware(['auth', 'verified']); // Resource Route, crud

# Log::class

Route::resource('/logs', LogController::class)->middleware(['auth', 'verified'])->only('show', 'index'); // Resource Route, crud

# Distrito::class

Route::get('/distritos/export/csv', [DistritoController::class, 'exportcsv'])->name('distritos.export.csv')->middleware('auth', 'verified');

Route::get('/distritos/export/xls', [DistritoController::class, 'exportxls'])->name('distritos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/distritos/export/pdf', [DistritoController::class, 'exportpdf'])->name('distritos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/distritos', DistritoController::class)->middleware(['auth', 'verified']);

# Unidade::class

Route::get('/unidades/export/csv', [UnidadeController::class, 'exportcsv'])->name('unidades.export.csv')->middleware('auth', 'verified');

Route::get('/unidades/export/xls', [UnidadeController::class, 'exportxls'])->name('unidades.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/unidades/export/pdf', [UnidadeController::class, 'exportpdf'])->name('unidades.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::get('/unidades/autocomplete', [UnidadeController::class, 'autocomplete'])->name('unidades.autocomplete')->middleware('auth', 'verified');

Route::resource('/unidades', UnidadeController::class)->middleware(['auth', 'verified']);

# Cargo::class

Route::get('/cargos/export/csv', [CargoController::class, 'exportcsv'])->name('cargos.export.csv')->middleware('auth', 'verified');

Route::get('/cargos/export/xls', [CargoController::class, 'exportxls'])->name('cargos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/cargos/export/pdf', [CargoController::class, 'exportpdf'])->name('cargos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/cargos', CargoController::class)->middleware(['auth', 'verified']);

# CargaHoraria::class

Route::get('/cargahorarias/export/csv', [CargaHorariaController::class, 'exportcsv'])->name('cargahorarias.export.csv')->middleware('auth', 'verified');

Route::get('/cargahorarias/export/xls', [CargaHorariaController::class, 'exportxls'])->name('cargahorarias.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/cargahorarias/export/pdf', [CargaHorariaController::class, 'exportpdf'])->name('cargahorarias.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/cargahorarias', CargaHorariaController::class)->middleware(['auth', 'verified']);

# Vinculo::class

Route::get('/vinculos/export/csv', [VinculoController::class, 'exportcsv'])->name('vinculos.export.csv')->middleware('auth', 'verified');

Route::get('/vinculos/export/xls', [VinculoController::class, 'exportxls'])->name('vinculos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/vinculos/export/pdf', [VinculoController::class, 'exportpdf'])->name('vinculos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/vinculos', VinculoController::class)->middleware(['auth', 'verified']);

# LicencaTipo::class

Route::get('/licencatipos/export/csv', [LicencaTipoController::class, 'exportcsv'])->name('licencatipos.export.csv')->middleware('auth', 'verified');

Route::get('/licencatipos/export/xls', [LicencaTipoController::class, 'exportxls'])->name('licencatipos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/licencatipos/export/pdf', [LicencaTipoController::class, 'exportpdf'])->name('licencatipos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/licencatipos', LicencaTipoController::class)->middleware(['auth', 'verified']);

# FeriasTipo::class

Route::get('/feriastipos/export/csv', [FeriasTipoController::class, 'exportcsv'])->name('feriastipos.export.csv')->middleware('auth', 'verified');

Route::get('/feriastipos/export/xls', [FeriasTipoController::class, 'exportxls'])->name('feriastipos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/feriastipos/export/pdf', [FeriasTipoController::class, 'exportpdf'])->name('feriastipos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/feriastipos', FeriasTipoController::class)->middleware(['auth', 'verified']);

# CapacitacaoTipo::class

Route::get('/capacitacaotipos/export/csv', [CapacitacaoTipoController::class, 'exportcsv'])->name('capacitacaotipos.export.csv')->middleware('auth', 'verified');

Route::get('/capacitacaotipos/export/xls', [CapacitacaoTipoController::class, 'exportxls'])->name('capacitacaotipos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/capacitacaotipos/export/pdf', [CapacitacaoTipoController::class, 'exportpdf'])->name('capacitacaotipos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/capacitacaotipos', CapacitacaoTipoController::class)->middleware(['auth', 'verified']);

# OrgaoEmissor::class

Route::get('/orgaoemissors/export/csv', [OrgaoEmissorController::class, 'exportcsv'])->name('orgaoemissors.export.csv')->middleware('auth', 'verified');

Route::get('/orgaoemissors/export/xls', [OrgaoEmissorController::class, 'exportxls'])->name('orgaoemissors.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/orgaoemissors/export/pdf', [OrgaoEmissorController::class, 'exportpdf'])->name('orgaoemissors.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/orgaoemissors', OrgaoEmissorController::class)->middleware(['auth', 'verified']);

# VinculoTipo::class

Route::get('/vinculotipos/export/csv', [VinculoTipoController::class, 'exportcsv'])->name('vinculotipos.export.csv')->middleware('auth', 'verified');

Route::get('/vinculotipos/export/xls', [VinculoTipoController::class, 'exportxls'])->name('vinculotipos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/vinculotipos/export/pdf', [VinculoTipoController::class, 'exportpdf'])->name('vinculotipos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/vinculotipos', VinculoTipoController::class)->middleware(['auth', 'verified']);

# Profissional::class

Route::get('/profissionals/export/csv', [ProfissionalController::class, 'exportcsv'])->name('profissionals.export.csv')->middleware('auth', 'verified');

Route::get('/profissionals/export/xls', [ProfissionalController::class, 'exportxls'])->name('profissionals.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/profissionals/export/pdf', [ProfissionalController::class, 'exportpdf'])->name('profissionals.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::get('/profissionals/autocomplete', [ProfissionalController::class, 'autocomplete'])->name('profissionals.autocomplete')->middleware('auth', 'verified');

# Profissional trash

Route::get('/profissionals/trash', [ProfissionalTrashController::class, 'index'])->name('profissionals.trash')->middleware('auth', 'verified');

Route::get('/profissionals/trash/{id}', [ProfissionalTrashController::class, 'show'])->name('profissionals.trash.show')->middleware('auth', 'verified');

Route::post('/profissionals/trash/{id}/restore', [ProfissionalTrashController::class, 'restore'])->name('profissionals.trash.restore')->middleware('auth', 'verified');

# Profissional, export to json

Route::get('/profissionals/export/json/{profissional}', [ProfissionalController::class, 'exportjson'])->name('profissionals.export.json')->middleware('auth', 'verified');

Route::resource('/profissionals', ProfissionalController::class)->middleware(['auth', 'verified']);

# Ferias::class

Route::get('/ferias/export/csv', [FeriasController::class, 'exportcsv'])->name('ferias.export.csv')->middleware('auth', 'verified');

Route::get('/ferias/export/xls', [FeriasController::class, 'exportxls'])->name('ferias.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/ferias/export/pdf', [FeriasController::class, 'exportpdf'])->name('ferias.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/ferias', FeriasController::class)->middleware(['auth', 'verified']);

# licencas::class

Route::get('/licencas/export/csv', [LicencaController::class, 'exportcsv'])->name('licencas.export.csv')->middleware('auth', 'verified');

Route::get('/licencas/export/xls', [LicencaController::class, 'exportxls'])->name('licencas.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/licencas/export/pdf', [LicencaController::class, 'exportpdf'])->name('licencas.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/licencas', LicencaController::class)->middleware(['auth', 'verified']);

# ProfissionalFerias::class

Route::post('/profissionalferias', [ProfissionalFeriasController::class, 'store'])->name('profisionalferias.store')->middleware('auth', 'verified');

Route::delete('/profissionalferias/{id}', [ProfissionalFeriasController::class, 'destroy'])->name('profisionalferias.destroy')->middleware('auth', 'verified');

# ProfissionalLicenca::class

Route::post('/profissionallicencas', [ProfissionalLicencaController::class, 'store'])->name('profissionallicencas.store')->middleware('auth', 'verified');

Route::delete('/profissionallicencas/{licenca}', [ProfissionalLicencaController::class, 'destroy'])->name('profissionallicencas.destroy')->middleware('auth', 'verified');

#ProfissionalCapacitacao::class

Route::post('/profissionalcapacitacoes', [ProfissionalCapacitacaoController::class, 'store'])->name('profissionalcapacitacoes.store')->middleware('auth', 'verified');

Route::delete('/profissionalcapacitacoes/{capacitacao}', [ProfissionalCapacitacaoController::class, 'destroy'])->name('profissionalcapacitacoes.destroy')->middleware('auth', 'verified');

# EquipeTipo::class

Route::get('/equipetipos/export/csv', [EquipeTipoController::class, 'exportcsv'])->name('equipetipos.export.csv')->middleware('auth', 'verified');

Route::get('/equipetipos/export/xls', [EquipeTipoController::class, 'exportxls'])->name('equipetipos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/equipetipos/export/pdf', [EquipeTipoController::class, 'exportpdf'])->name('equipetipos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/equipetipos', EquipeTipoController::class)->middleware(['auth', 'verified']);

# Equipe::class

Route::get('/equipes/export/csv', [EquipeController::class, 'exportcsv'])->name('equipes.export.csv')->middleware('auth', 'verified');

Route::get('/equipes/export/xls', [EquipeController::class, 'exportxls'])->name('equipes.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/equipes/export/pdf', [EquipeController::class, 'exportpdf'])->name('equipes.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/equipes', EquipeController::class)->middleware(['auth', 'verified']);

# EquipeVagas::class

Route::resource('/equipevagas', EquipeVagasController::class)->only(['store', 'destroy',])->middleware(['auth', 'verified']);

# EquipeGestao::class

/* Gestão das equipes */
Route::get('/equipegestao/export/csv', [EquipeGestaoController::class, 'exportcsv'])->name('equipegestao.export.csv')->middleware('auth', 'verified');

Route::get('/equipegestao/export/xls', [EquipeGestaoController::class, 'exportxls'])->name('equipegestao.export.xls')->middleware('auth', 'verified');

Route::get('/equipegestao/export/csv/completo', [EquipeGestaoController::class, 'exportcsvcompleto'])->name('equipegestao.export.csv.completo')->middleware('auth', 'verified');

Route::get('/equipegestao/export/pdf', [EquipeGestaoController::class, 'exportpdf'])->name('equipegestao.export.pdf')->middleware('auth', 'verified');

Route::get('/equipegestao/export/pdf/{id}/individual', [EquipeGestaoController::class, 'exportpdfindividual'])->name('equipegestao.export.pdf.individual')->middleware('auth', 'verified');

Route::post('/equipegestao/preenchervaga', [EquipeGestaoController::class, 'preenchervaga'])->name('equipegestao.preenchervaga')->middleware('auth', 'verified');

Route::post('/equipegestao/limparvaga', [EquipeGestaoController::class, 'limparvaga'])->name('equipegestao.limparvaga')->middleware('auth', 'verified');

Route::post('/equipegestao/registrarvaga', [EquipeGestaoController::class, 'registrarvaga'])->name('equipegestao.registrarvaga')->middleware('auth', 'verified');

Route::resource('/equipegestao', EquipeGestaoController::class)->only(['index', 'show',])->middleware(['auth', 'verified']);

# Equipes::View

Route::get('/equipeview/export/csv/simples', [EquipeViewController::class, 'exportcsvsimples'])->name('equipeview.export.csv.simples')->middleware('auth', 'verified');

Route::get('/equipeview/export/xls/simples', [EquipeViewController::class, 'exportxlssimples'])->name('equipeview.export.xls.simples')->middleware('auth', 'verified');

Route::get('/equipeview/export/csv/completo', [EquipeViewController::class, 'exportcsvcompleto'])->name('equipeview.export.csv.completo')->middleware('auth', 'verified');

Route::get('/equipeview/export/xls/completo', [EquipeViewController::class, 'exportxlscompleto'])->name('equipeview.export.xls.completo')->middleware('auth', 'verified');

Route::get('/equipeview/export/pdf', [EquipeViewController::class, 'exportpdf'])->name('equipeview.export.pdf')->middleware('auth', 'verified');

Route::get('/equipeview', [EquipeViewController::class, 'index'])->name('equipeview.index')->middleware('auth', 'verified');

Route::get('/equipeview/{id}', [EquipeViewController::class, 'show'])->name('equipeview.show')->middleware('auth', 'verified');

# Historico

Route::get('/historico/export/csv/completo', [HistoricoController::class, 'exportcsv'])->name('historico.export.csv')->middleware('auth', 'verified');

Route::get('/historico/export/xls/completo', [HistoricoController::class, 'exportxls'])->name('historico.export.xls')->middleware('auth', 'verified');

Route::get('/historico', [historicoController::class, 'index'])->name('historico.index')->middleware('auth', 'verified');

