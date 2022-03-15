<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\ActividadController;

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
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('actividades', ActividadController::class);
    Route::get('actividades/asignar/{id}', [\App\Http\Controllers\ActividadController::class, 'asignar'])->name('actividades.asignar');
    Route::post('actividades/asignacion', [\App\Http\Controllers\ActividadController::class, 'asignacion'])->name('actividades.asignacion');
    // Route::post('actividades/asignacion/{id}', [\App\Http\Controllers\ActividadController::class, 'asignacionUpdate'])->name('actividades.asignacion.update');
    Route::delete('actividades/asignacion/{id}/{actividad_id}', [\App\Http\Controllers\ActividadController::class, 'asignacionDestroy'])->name('actividades.asignacion.destroy');
    Route::get('reporteVehiculo', [\App\Http\Controllers\ReporteController::class, 'vehiculo'])->name('reporteVehiculo');
    Route::post('reporteV', [\App\Http\Controllers\ReporteController::class, 'reporteVehiculo'])->name('reporteV');
    Route::get('reporteTecnico', [\App\Http\Controllers\ReporteController::class, 'tecnico'])->name('reporteTecnico');
    Route::post('reporteT', [\App\Http\Controllers\ReporteController::class, 'reporteTecnico'])->name('reporteT');
});
