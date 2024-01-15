<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad_Tecnico;
use App\Models\Vehiculo;
use App\Models\Tecnico;
use App\Models\Horario;
use App\Models\Prestamo;
use PDF;


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

    public function pdfVehiculoDia(Request $request, $fecha)
    {
        // $this->validate($request, [
        //     'fecha_inicio' => 'required',
        // ]);
        // $fecha_inicio = $request->post('fecha_inicio');

        $horarios = Horario::get();
        $vehiculos = Vehiculo::get();
        $listaVehiculos = Actividad_Tecnico::listaVehiculos($fecha);
        $listaActividades = Actividad_Tecnico::listaActividades($fecha);

        $pdf = PDF::loadView('reportes.vehiculo.pdfDia',['horarios'=>$horarios,'vehiculos'=>$vehiculos,'listaVehiculos'=>$listaVehiculos,'listaActividades'=>$listaActividades,'fecha'=>$fecha]);
        return $pdf->download('ReporteVehiculosActividadesDia'.$fecha.'.pdf');
        // return view('reportes.vehiculo.pdfDia',compact('listaVehiculos','listaActividades','fecha','horarios','vehiculos'));
    }

    public function reporteVehiculoActividad(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required',
            'vehiculo_id' => 'required',
        ]);
        $fecha_inicio = $request->post('fecha_inicio');
        $fecha_final = strtotime('-10 day', strtotime($fecha_inicio));
        $fecha_final = date('Y-m-d', $fecha_final);
        $vehiculo_id = $request->post('vehiculo_id');

        function fechas($start, $end) {
            $range = array();

            if (is_string($start) === true) $start = strtotime($start);
            if (is_string($end) === true ) $end = strtotime($end);

            if ($start > $end) return createDateRangeArray($end, $start);

            do {
                $range[] = date('Y-m-d', $start);
                $start = strtotime("+ 1 day", $start);
            } while($start <= $end);

            return $range;
        }

        $fechas = fechas($fecha_final,$fecha_inicio);

        $horarios = Horario::get();
        $vehiculo = Vehiculo::find($vehiculo_id);
        $lista = Actividad_Tecnico::listaVehiculo($fecha_inicio, $fecha_final, $vehiculo_id);
        // dd($horarios);
        // die();
        return view('reportes.vehiculo.reporteActividad',compact('lista','fecha_inicio','fecha_final','horarios','vehiculo','fechas'));
    }

    public function pdfVehiculoActividad(Request $request, $fecha, $vehiculo)
    {
        $fecha_final = strtotime('-10 day', strtotime($fecha));
        $fecha_final = date('Y-m-d', $fecha_final);

        function fechas($start, $end) {
            $range = array();

            if (is_string($start) === true) $start = strtotime($start);
            if (is_string($end) === true ) $end = strtotime($end);

            if ($start > $end) return createDateRangeArray($end, $start);

            do {
                $range[] = date('Y-m-d', $start);
                $start = strtotime("+ 1 day", $start);
            } while($start <= $end);

            return $range;
        }

        $fechas = fechas($fecha_final,$fecha);

        $horarios = Horario::get();
        $vehiculo = Vehiculo::find($vehiculo);
        $lista = Actividad_Tecnico::listaVehiculo($fecha, $fecha_final, $vehiculo->id);

        $pdf = PDF::loadView('reportes.vehiculo.pdfActividad',['vehiculo'=>$vehiculo,'lista'=>$lista,'fechas'=>$fechas,'horarios'=>$horarios])->setPaper('letter', 'landscape');
        return $pdf->download('Reporte '.$fecha.'-'.$vehiculo->vehiculo.'.pdf');
        // return view('reportes.vehiculo.pdfDia',compact('listaVehiculos','listaActividades','fecha','horarios','vehiculos'));
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

    public function reportePAT()
    {
        $vehiculos = Vehiculo::listaEtapa();
        return view('reportes.pat.index',compact('vehiculos'));
    }

    public function pdfPAT()
    {
        $vehiculos = Vehiculo::listaEtapa();

        $pdf = PDF::loadView('reportes.pat.pdfPAT',['vehiculos'=>$vehiculos]);
        return $pdf->download('ReportePAT.pdf');
        // return view('reportes.vehiculo.pdfDia',compact('listaVehiculos','listaActividades','fecha','horarios','vehiculos'));
    }

    public function rPAT(Request $request)
    {
        // $this->validate($request, [
        //     'fecha_inicio' => 'required',
        //     'fecha_final' => 'required',
        //     'tecnico_id' => 'required',
        // ]);
        // $fecha_inicio = $request->post('fecha_inicio');
        // $fecha_final = $request->post('fecha_final');
        // $tecnico_id = $request->post('tecnico_id');
        // $horarios = Horario::get();
        // $tecnico = Tecnico::find($tecnico_id);
        // $lista = Actividad_Tecnico::listaTecnico($fecha_inicio, $fecha_final, $tecnico_id);
        // return view('reportes.tecnico.reporte',compact('lista','fecha_inicio','fecha_final','horarios','tecnico'));
    }

    public function prestamo()
    {
        $prestamos = Prestamo::orderBy('tecnico_id')->get();
        return view('reportes.prestamo.index', compact('prestamos'));
    }

    public function pdfPrestamo()
    {
        $prestamos = Prestamo::orderBy('tecnico_id')->get();
        $pdf = PDF::loadView('reportes.prestamo.pdfPrestamo',['prestamos'=>$prestamos]);
        return $pdf->download('ReportePrestamos.pdf');
    }

}
