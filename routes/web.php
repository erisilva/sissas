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

Route::resource('/permissions', PermissionController::class)->middleware('auth', 'verified'); // Resource Route, crud

# Role::class

Route::get('/roles/export/csv', [RoleController::class, 'exportcsv'])->name('roles.export.csv')->middleware('auth', 'verified'); // Export CSV

Route::get('/roles/export/xls', [RoleController::class, 'exportxls'])->name('roles.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/roles/export/pdf', [RoleController::class, 'exportpdf'])->name('roles.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/roles', RoleController::class)->middleware('auth', 'verified'); // Resource Route, crud

# User::class

Route::get('/users/export/csv', [UserController::class, 'exportcsv'])->name('users.export.csv')->middleware('auth', 'verified'); // Export CSV

Route::get('/users/export/xls', [UserController::class, 'exportxls'])->name('users.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/users/export/pdf', [UserController::class, 'exportpdf'])->name('users.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/users', UserController::class)->middleware('auth', 'verified'); // Resource Route, crud

# Log::class

Route::resource('/logs', LogController::class)->middleware('auth', 'verified')->only('show', 'index'); // Resource Route, crud

# Distrito::class

Route::get('/distritos/export/csv', [DistritoController::class, 'exportcsv'])->name('distritos.export.csv')->middleware('auth', 'verified');

Route::get('/distritos/export/xls', [DistritoController::class, 'exportxls'])->name('distritos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/distritos/export/pdf', [DistritoController::class, 'exportpdf'])->name('distritos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/distritos', DistritoController::class)->middleware('auth', 'verified');

# Unidade::class

Route::get('/unidades/export/csv', [UnidadeController::class, 'exportcsv'])->name('unidades.export.csv')->middleware('auth', 'verified');

Route::get('/unidades/export/xls', [UnidadeController::class, 'exportxls'])->name('unidades.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/unidades/export/pdf', [UnidadeController::class, 'exportpdf'])->name('unidades.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/unidades', UnidadeController::class)->middleware('auth', 'verified');

# Cargo::class

Route::get('/cargos/export/csv', [CargoController::class, 'exportcsv'])->name('cargos.export.csv')->middleware('auth', 'verified');

Route::get('/cargos/export/xls', [CargoController::class, 'exportxls'])->name('cargos.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/cargos/export/pdf', [CargoController::class, 'exportpdf'])->name('cargos.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/cargos', CargoController::class)->middleware('auth', 'verified');

# CargaHoraria::class

Route::get('/cargahorarias/export/csv', [CargaHorariaController::class, 'exportcsv'])->name('cargahorarias.export.csv')->middleware('auth', 'verified');

Route::get('/cargahorarias/export/xls', [CargaHorariaController::class, 'exportxls'])->name('cargahorarias.export.xls')->middleware('auth', 'verified'); // Export XLS

Route::get('/cargahorarias/export/pdf', [CargaHorariaController::class, 'exportpdf'])->name('cargahorarias.export.pdf')->middleware('auth', 'verified'); // Export PDF

Route::resource('/cargahorarias', CargaHorariaController::class)->middleware('auth', 'verified');