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
Route::resource('/unidades', 'UnidadeController');

/* Cargos */
Route::get('/cargos/export/csv', 'CargoController@exportcsv')->name('cargos.export.csv');
Route::get('/cargos/export/pdf', 'CargoController@exportpdf')->name('cargos.export.pdf');
Route::resource('/cargos', 'CargoController');