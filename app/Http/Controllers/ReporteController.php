<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad_Tecnico;
use App\Models\Vehiculo;
use App\Models\Tecnico;
use App\Models\Horario;
// use PDF;

class ReporteController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:ver-reporte|crear-reporte|editar-reporte|borrar-reporte', ['only' => ['vehiculo','tecnico']]);
        //  $this->middleware('permission:crear-reporte', ['only' => ['create','store']]);
        //  $this->middleware('permission:editar-reporte', ['only' => ['edit','update']]);
        //  $this->middleware('permission:borrar-reporte', ['only' => ['destroy']]);
    }

    public function vehiculo()
    {
        $vehiculos = Vehiculo::get();
        return view('reportes.vehiculo.index', compact('vehiculos'));
    }

    public function reporteVehiculo(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'vehiculo_id' => 'required',
        ]);
        $fecha_inicio = $request->post('fecha_inicio');
        $fecha_final = $request->post('fecha_final');
        $vehiculo_id = $request->post('vehiculo_id');
        $horarios = Horario::get();
        $vehiculo = Vehiculo::find($vehiculo_id);
        $lista = Actividad_Tecnico::listaVehiculo($fecha_inicio, $fecha_final, $vehiculo_id);
        return view('reportes.vehiculo.reporte',compact('lista','fecha_inicio','fecha_final','horarios','vehiculo'));
    }

    public function tecnico()
    {
        $tecnicos = Tecnico::get();
        return view('reportes.tecnico.index',compact('tecnicos'));
    }

    public function reporteTecnico(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'tecnico_id' => 'required',
        ]);
        $fecha_inicio = $request->post('fecha_inicio');
        $fecha_final = $request->post('fecha_final');
        $tecnico_id = $request->post('tecnico_id');
        $horarios = Horario::get();
        $tecnico = Tecnico::find($tecnico_id);
        $lista = Actividad_Tecnico::listaTecnico($fecha_inicio, $fecha_final, $tecnico_id);
        return view('reportes.tecnico.reporte',compact('lista','fecha_inicio','fecha_final','horarios','tecnico'));
    }

}
