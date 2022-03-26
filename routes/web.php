<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\TrasladoController;
use App\Http\Controllers\AltaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('administrativos', AdministrativoController::class);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('sucursales', SucursalController::class);
    Route::resource('prestamos', PrestamoController::class);
    Route::resource('traslados', TrasladoController::class);
    Route::resource('altas', AltaController::class);
    Route::resource('actividades', ActividadController::class);
    Route::get('usuarios/asignar/{id}', [UsuarioController::class, 'asignar'])->name('usuarios.asignar');
    Route::patch('usuarios/asignacion/{id}', [UsuarioController::class, 'asignacion'])->name('usuarios.asignacion');
    Route::delete('usuarios/asignacion/{id}', [UsuarioController::class, 'asignacionDestroy'])->name('usuarios.asignacion.destroy');
    Route::get('traslados/aprobar/{id}', [TrasladoController::class, 'aprobar'])->name('traslados.aprobar');
    Route::patch('traslados/aprobacion/{id}', [TrasladoController::class, 'aprobacion'])->name('traslados.aprobacion');
    Route::get('actividades/asignar/{id}', [ActividadController::class, 'asignar'])->name('actividades.asignar');
    Route::post('actividades/asignacion', [ActividadController::class, 'asignacion'])->name('actividades.asignacion');
    Route::get('actividades/agregaValor/{id}', [ActividadController::class, 'agregarValor'])->name('actividades.agregaValor');
    Route::post('actividades/guardaValor', [ActividadController::class, 'guardarValor'])->name('actividades.guardaValor');
    Route::delete('actividades/asignacion/{id}/{actividad_id}', [ActividadController::class, 'asignacionDestroy'])->name('actividades.asignacion.destroy');
    // Route::post('actividades/asignacion/{id}', [ActividadController::class, 'asignacionUpdate'])->name('actividades.asignacion.update');
    Route::get('reporteVehiculo', [ReporteController::class, 'vehiculo'])->name('reporteVehiculo');
    Route::post('reporteV', [ReporteController::class, 'reporteVehiculo'])->name('reporteV');
    Route::get('reporteTecnico', [ReporteController::class, 'tecnico'])->name('reporteTecnico');
    Route::post('reporteT', [ReporteController::class, 'reporteTecnico'])->name('reporteT');
});
