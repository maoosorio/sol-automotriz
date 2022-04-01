<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad_Tecnico;
use App\Models\Vehiculo;
use App\Models\Tecnico;
use App\Models\Horario;


class ReporteController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:ver-reporte|crear-reporte|editar-reporte|borrar-reporte', ['only' => ['vehiculo','tecnico']]);
        //  $this->middleware('permission:crear-reporte', ['only' => ['create','store']]);
        //  $this->middleware('permission:editar-reporte', ['only' => ['edit','update']]);
        //  $this->middleware('permission:borrar-reporte', ['only' => ['destroy']]);
    }

    public function vehiculoDia()
    {
        $vehiculos = Vehiculo::get();
        return view('reportes.vehiculo.dia', compact('vehiculos'));
    }

    public function vehiculoActividad()
    {
        $vehiculos = Vehiculo::get();
        return view('reportes.vehiculo.actividad', compact('vehiculos'));
    }

    public function reporteVehiculoDia(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required',
        ]);
        $fecha_inicio = $request->post('fecha_inicio');
        $horarios = Horario::get();
        $vehiculos = Vehiculo::get();
        $listaVehiculos = Actividad_Tecnico::listaVehiculos($fecha_inicio);
        $listaActividades = Actividad_Tecnico::listaActividades($fecha_inicio);
        return view('reportes.vehiculo.reporteDia',compact('listaVehiculos','listaActividades','fecha_inicio','horarios','vehiculos'));
    }

    public function reporteVehiculoActividad(Request $request)
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
        return view('reportes.vehiculo.reporteActividad',compact('lista','fecha_inicio','fecha_final','horarios','vehiculo'));
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
