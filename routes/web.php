<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->namespace('Admin')->group(function () {
	/*  Operadores */
	// nota mental :: as rotas extras devem ser declaradas antes de se declarar as rotas resources
    Route::get('/users/password', 'ChangePasswordController@showPasswordUpdateForm')->name('users.password');
	Route::put('/users/password/update', 'ChangePasswordController@passwordUpdate')->name('users.passwordupdate');
    Route::get('/users/export/csv', 'UserController@exportcsv')->name('users.export.csv');
	Route::get('/users/export/pdf', 'UserController@exportpdf')->name('users.export.pdf');
    Route::resource('/users', 'UserController');

	/* Permissões */
    Route::get('/permissions/export/csv', 'PermissionController@exportcsv')->name('permissions.export.csv');
	Route::get('/permissions/export/pdf', 'PermissionController@exportpdf')->name('permissions.export.pdf');
    Route::resource('/permissions', 'PermissionController');

    /* Perfis */
    Route::get('/roles/export/csv', 'RoleController@exportcsv')->name('roles.export.csv');
    Route::get('/roles/export/pdf', 'RoleController@exportpdf')->name('roles.export.pdf');
    Route::resource('/roles', 'RoleController');
});

/* Distritos */
Route::get('/distritos/export/csv', 'DistritoController@exportcsv')->name('distritos.export.csv');
Route::get('/distritos/export/pdf', 'DistritoController@exportpdf')->name('distritos.export.pdf');
Route::resource('/distritos', 'DistritoController');

/* Unidades */
Route::get('/unidades/export/csv', 'UnidadeController@exportcsv')->name('unidades.export.csv');
Route::get('/unidades/export/pdf', 'UnidadeController@exportpdf')->name('unidades.export.pdf');
Route::get('/unidades/autocomplete', 'UnidadeController@autocomplete')->name('unidades.autocomplete');
Route::resource('/unidades', 'UnidadeController');
# Profissionais por Unidade
Route::resource('/unidadeprofissionais', 'UnidadeProfissionalController')->only(['store', 'destroy',]);

/* Cargos */
Route::get('/cargos/export/csv', 'CargoController@exportcsv')->name('cargos.export.csv');
Route::get('/cargos/export/pdf', 'CargoController@exportpdf')->name('cargos.export.pdf');
Route::resource('/cargos', 'CargoController');

/* Carga Horária */
Route::get('/cargahorarias/export/csv', 'CargaHorariaController@exportcsv')->name('cargahorarias.export.csv');
Route::get('/cargahorarias/export/pdf', 'CargaHorariaController@exportpdf')->name('cargahorarias.export.pdf');
Route::resource('/cargahorarias', 'CargaHorariaController');

/* Vínculos */
Route::get('/vinculos/export/csv', 'VinculoController@exportcsv')->name('vinculos.export.csv');
Route::get('/vinculos/export/pdf', 'VinculoController@exportpdf')->name('vinculos.export.pdf');
Route::resource('/vinculos', 'VinculoController');

/* Orgão Emissor */
Route::get('/orgaoemissores/export/csv', 'OrgaoEmissorController@exportcsv')->name('orgaoemissores.export.csv');
Route::get('/orgaoemissores/export/pdf', 'OrgaoEmissorController@exportpdf')->name('orgaoemissores.export.pdf');
Route::resource('/orgaoemissores', 'OrgaoEmissorController');

/* Tipos de Vínculos */
Route::get('/vinculotipos/export/csv', 'VinculoTipoController@exportcsv')->name('vinculotipos.export.csv');
Route::get('/vinculotipos/export/pdf', 'VinculoTipoController@exportpdf')->name('vinculotipos.export.pdf');
Route::resource('/vinculotipos', 'VinculoTipoController');

/* Tipos de Licenças */
Route::get('/licencatipos/export/csv', 'LicencaTipoController@exportcsv')->name('licencatipos.export.csv');
Route::get('/licencatipos/export/pdf', 'LicencaTipoController@exportpdf')->name('licencatipos.export.pdf');
Route::resource('/licencatipos', 'LicencaTipoController');

/* Tipos de Férias */
Route::get('/feriastipos/export/csv', 'FeriasTipoController@exportcsv')->name('feriastipos.export.csv');
Route::get('/feriastipos/export/pdf', 'FeriasTipoController@exportpdf')->name('feriastipos.export.pdf');
Route::resource('/feriastipos', 'FeriasTipoController');

/* Tipos de Capacitações */
Route::get('/capacitacaotipos/export/csv', 'CapacitacaoTipoController@exportcsv')->name('capacitacaotipos.export.csv');
Route::get('/capacitacaotipos/export/pdf', 'CapacitacaoTipoController@exportpdf')->name('capacitacaotipos.export.pdf');
Route::resource('/capacitacaotipos', 'CapacitacaoTipoController');

/* Profissionais */
Route::get('/profissionals/export/csv', 'ProfissionalController@exportcsv')->name('profissionals.export.csv');
Route::get('/profissionals/export/pdf', 'ProfissionalController@exportpdf')->name('profissionals.export.pdf');
Route::get('/profissionals/export/pdf/simples', 'ProfissionalController@exportpdfsimples')->name('profissionals.export.pdf.simples');
Route::get('/profissionals/export/pdf/{id}/individual', 'ProfissionalController@exportpdfindividual')->name('profissionals.export.pdf.individual');
Route::get('/profissionals/autocomplete', 'ProfissionalController@autocomplete')->name('profissionals.autocomplete');
# lixeira
Route::get('/profissionals/trash', 'ProfissionalTrashController@index')->name('profissionals.trash');
Route::get('/profissionals/trash/{id}', 'ProfissionalTrashController@show')->name('profissionals.trash.show');
Route::post('/profissionals/trash/{id}/restore', 'ProfissionalTrashController@restore')->name('profissionals.trash.restore');
# resource
Route::resource('/profissionals', 'ProfissionalController');
/* Férias dos profissionais */
Route::get('/ferias/export/csv', 'FeriasController@exportcsv')->name('ferias.export.csv');
Route::get('/ferias/export/pdf', 'FeriasController@exportpdf')->name('ferias.export.pdf');
Route::resource('/ferias', 'FeriasController')->only(['store', 'destroy', 'index']);
/* Licenças dos profissionais */
Route::get('/licencas/export/csv', 'LicencaController@exportcsv')->name('licencas.export.csv');
Route::get('/licencas/export/pdf', 'LicencaController@exportpdf')->name('licencas.export.pdf');
Route::resource('/licencas', 'LicencaController')->only(['store', 'destroy', 'index']);
/* Capacitações dos profissionais */
Route::resource('/capacitacaos', 'CapacitacaoController')->only(['store', 'destroy',]);

/* Equipes/Vagas */
Route::get('/equipes/export/csv', 'EquipeController@exportcsv')->name('equipes.export.csv');
Route::get('/equipes/export/pdf', 'EquipeController@exportpdf')->name('equipes.export.pdf');
Route::get('/equipes/export/pdf/{id}/individual', 'EquipeController@exportpdfindividual')->name('equipes.export.pdf.individual');
# lixeira
Route::get('/equipes/trash', 'EquipeTrashController@index')->name('equipes.trash');
Route::get('/equipes/trash/{id}', 'EquipeTrashController@show')->name('equipes.trash.show');
Route::post('/equipes/trash/{id}/restore', 'EquipeTrashController@restore')->name('equipes.trash.restore');
# Vagas da Equipe
Route::resource('/equipevagas', 'EquipeVagasController')->only(['store', 'destroy',]);
# resource
Route::resource('/equipes', 'EquipeController');

/* Gestão das equipes */
Route::get('/equipegestao/export/csv', 'EquipeGestaoController@exportcsv')->name('equipegestao.export.csv');
Route::get('/equipegestao/export/csv/completo', 'EquipeGestaoController@exportcsvcompleto')->name('equipegestao.export.csv.completo');
Route::get('/equipegestao/export/pdf', 'EquipeGestaoController@exportpdf')->name('equipegestao.export.pdf');
Route::get('/equipegestao/export/pdf/{id}/individual', 'EquipeGestaoController@exportpdfindividual')->name('equipegestao.export.pdf.individual');
Route::post('/equipegestao/preenchervaga', 'EquipeGestaoController@preenchervaga')->name('equipegestao.preenchervaga');
Route::post('/equipegestao/limparvaga', 'EquipeGestaoController@limparvaga')->name('equipegestao.limparvaga');
Route::resource('/equipegestao', 'EquipeGestaoController')->only(['index', 'show',]);

/* Histórico */
Route::get('/historicos/export/csv', 'HistoricoController@exportcsv')->name('historicos.export.csv');
Route::get('/historicos/export/pdf', 'HistoricoController@exportpdf')->name('historicos.export.pdf');
Route::resource('/historicos', 'HistoricoController')->only(['index']);