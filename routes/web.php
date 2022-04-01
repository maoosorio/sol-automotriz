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

// Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/inicio', [HomeController::class, 'inicio'])->name('inicio');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/sucursal/{id}', [HomeController::class, 'sucursal'])->name('sucursal');
Route::patch('/sucursal/asociar/{id}', [HomeController::class, 'asociar'])->name('sucursal.asociar');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('administrativos', AdministrativoController::class);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('sucursales', SucursalController::class);
    Route::resource('traslados', TrasladoController::class);
    Route::resource('prestamos', PrestamoController::class);
    Route::resource('altas', AltaController::class);
    Route::resource('actividades', ActividadController::class);

    // Route::get('traslados/create', [TrasladoController::class, 'create'])->name('traslados.create');
    // Route::get('traslados/create', function () { $sucursales = App\Models\Sucursal::where('nombre', 'not like', "Todas")->get(); return view('traslados.crear',['sucursales' => $sucursales]); });
    Route::get('traslados/create/{id}', function ($id) { $vehiculos = App\Models\Vehiculo::where('sucursal_id',$id)->get(); return response()->json($vehiculos); });

    Route::get('altas/create/{id}', function ($id) { $vehiculos = App\Models\Vehiculo::where('sucursal_id',$id)->get(); return response()->json($vehiculos); });

    Route::get('usuarios/asignar/{id}', [UsuarioController::class, 'asignar'])->name('usuarios.asignar');
    Route::patch('usuarios/asignacion/{id}', [UsuarioController::class, 'asignacion'])->name('usuarios.asignacion');
    Route::delete('usuarios/asignacion/{id}', [UsuarioController::class, 'asignacionDestroy'])->name('usuarios.asignacion.destroy');
    Route::get('traslados/aprobar/{id}', [TrasladoController::class, 'aprobar'])->name('traslados.aprobar');
    Route::patch('traslados/aprobacion/{id}', [TrasladoController::class, 'aprobacion'])->name('traslados.aprobacion');
    Route::get('actividades/asignar/{id}', [ActividadController::class, 'asignar'])->name('actividades.asignar');
    Route::post('actividades/asignacion', [ActividadController::class, 'asignacion'])->name('actividades.asignacion');

    Route::get('actividades/agregaValorMe/{id}', [ActividadController::class, 'agregaValorMe'])->name('actividades.agregaValorMe');
    Route::post('actividades/guardaValorMe', [ActividadController::class, 'guardaValor'])->name('actividades.guardaValor');
    Route::get('actividades/agregaValorMo/{id}', [ActividadController::class, 'agregaValorMo'])->name('actividades.agregaValorMo');
    Route::post('actividades/guardaValor', [ActividadController::class, 'guardaValor'])->name('actividades.guardaValor');
    Route::get('actividades/aprobarValorMe/{id}', [ActividadController::class, 'aprobarValorMe'])->name('actividades.aprobarValorMe');
    Route::post('actividades/guardaValorMe', [ActividadController::class, 'guardaValor'])->name('actividades.guardaValor');
    Route::get('actividades/aprobarValorMo/{id}', [ActividadController::class, 'aprobarValorMo'])->name('actividades.aprobarValorMo');
    Route::post('actividades/guardaValor', [ActividadController::class, 'guardaValor'])->name('actividades.guardaValor');

    Route::delete('actividades/asignacion/{id}/{actividad_id}', [ActividadController::class, 'asignacionDestroy'])->name('actividades.asignacion.destroy');
    // Route::post('actividades/asignacion/{id}', [ActividadController::class, 'asignacionUpdate'])->name('actividades.asignacion.update');
    Route::get('reporteVehiculoDia', [ReporteController::class, 'vehiculoDia'])->name('reporteVehiculoDia');
    Route::post('reporteVD', [ReporteController::class, 'reporteVehiculoDia'])->name('reporteVD');
    Route::get('reporteVehiculoActividad', [ReporteController::class, 'vehiculoActividad'])->name('reporteVehiculoActividad');
    Route::post('reporteVA', [ReporteController::class, 'reporteVehiculoActividad'])->name('reporteVA');
    Route::get('reporteTecnico', [ReporteController::class, 'tecnico'])->name('reporteTecnico');
    Route::post('reporteT', [ReporteController::class, 'reporteTecnico'])->name('reporteT');
});
