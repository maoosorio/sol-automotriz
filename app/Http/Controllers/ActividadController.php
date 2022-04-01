<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Tecnico;
use App\Models\Vehiculo;
use App\Models\Horario;
use App\Models\Actividad_Tecnico;
use App\Models\UsuarioLog;

class ActividadController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:5 ver-actividad|5.1 crear-actividad|5.2 ver-asignacion|5.3 borrar-actividad|5.4 ver-asignacion', ['only' => ['index']]);
         $this->middleware('permission:5.1 crear-actividad', ['only' => ['create','store']]);
         $this->middleware('permission:5.2 ver-asignacion', ['only' => ['asignar']]);
         $this->middleware('permission:5.3 borrar-actividad', ['only' => ['destroy']]);
         $this->middleware('permission:5.2.1 crear-asignacion', ['only' => ['asignacion']]);
         $this->middleware('permission:5.2.3 borrar-asignacion', ['only' => ['asignacionDestroy']]);
         $this->middleware('permission:5.2.4 agregar-valorme', ['only' => ['agregaValorMe', 'guardarValor']]);
         $this->middleware('permission:5.2.5 agregar-valormo', ['only' => ['agregaValorMo', 'guardarValor']]);
         $this->middleware('permission:5.2.6 aprobar-valorme', ['only' => ['aprobarValorMe', 'guardarValor']]);
         $this->middleware('permission:5.2.7 aprobar-valormo', ['only' => ['aprrobarValorMo', 'guardarValor']]);

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoy = date('Y-m-d');
        $dia=date("w", strtotime($hoy));
         if($dia == 1){
         $ayer = strtotime('-2 day', strtotime($hoy));
         }else{
         $ayer = strtotime('-1 day', strtotime($hoy));
        }
        $ayer = date('Y-m-d', $ayer);
        if(auth()->user()->sucursal_id == 1) {
            $actividades = Actividad::whereBetween('fecha', [$ayer, $hoy])->orderBy('fecha', 'asc')->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $actividades = Actividad::sucursal($sucursal_id, $ayer, $hoy);
            // $actividades = Actividad::whereBetween('fecha', [$ayer, $hoy])->orderBy('fecha', 'asc')->get();
        }
        $status = '';
        $color = '';
        return view('actividades.index',compact('actividades','status','color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actividades = Actividad::get();
        if(auth()->user()->sucursal_id == 1) {
            $tecnicos = Tecnico::where('tipo','Tecnico')->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Tecnico']])->get();
        }
        return view('actividades.crear',compact('actividades', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fecha' => 'required|date',
            'tecnico_id' => 'required',
        ]);
        try {

            $actividades = Actividad::create(['fecha' => $request->input('fecha'),'tecnico_id' => $request->input('tecnico_id')]);

            $id = auth()->user()->id;
            $accion = 'crear actividad';
            $tabla = 'actividad';
            $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
            $status = 'Se agregó exitosamente';
            $color = 'success';

                } catch (\Illuminate\Database\QueryException $e) {
                    $status = 'No se puedo agregar al tecnico dos veces el mismo día';
                    $color = 'danger';
                }
        return redirect()->route('actividades.index')->with('status',$status)->with('color',$color);
        // return view('actividades.index',compact('actividades','status','color'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actividad = Actividad::find($id);
        $tecnicos = Tecnico::where('tipo','Tecnico')->get();
        return view('actividades.editar', compact('actividad', 'tecnicos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actividad = Actividad::find($id);
        $actividad->fecha = $request->input('fecha');
        $actividad->tecnico_id = $request->input('tecnico_id');
        $actividad->update();

        $id = auth()->user()->id;
        $accion = 'actualizar actividad';
        $tabla = 'actividad';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('actividades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = Actividad::find($id);
        try {
            $actividad->delete();
            $status = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $status = 'No se puede eliminar si tiene actividades asignadas';
        }
        return redirect()->route('actividades.index')->with('status', $status);
    }

    public function asignar($id)
    {
        $actividad = Actividad::find($id);
        $actividades = Actividad_Tecnico::where('actividad_id', $id)->orderBy('horario_id', 'asc')->get();
        $horarios = Horario::get();
        if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','Activo')->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id], ['estado', '=', 'activo']])->get();
        }
        $status = '';
        $lista = Actividad_Tecnico::lista($id);
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista', 'status'));
    }

    public function asignacion(Request $request)
    {
        $this->validate($request, [
            'horario_id' => 'required',
            'actividad_id' => 'required',
            'vehiculo_id' => 'required',
            'actividad' => 'required',
            ]);
            $hora = $request->input('horario_id');

            try {
            for($i = 0; $i < count($hora); $i++) {
                    $actividades = Actividad_Tecnico::create(['horario_id' => $hora[$i],'actividad_id' => $request->input('actividad_id'), 'vehiculo_id' => $request->input('vehiculo_id'),'actividad' => $request->input('actividad')]);

                    $id = auth()->user()->id;
                    $accion = 'crear asignacion';
                    $tabla = 'actividad_tecnico';
                    $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
                    $status = 'Se agregó exitosamente';
                    $color = 'success';
                }
                } catch (\Illuminate\Database\QueryException $e) {
                    $status = 'No se pudo agregar, verificar que la hora no esté repetida';
                    $color = 'danger';
                }
            $actividad = Actividad::find($request->input('actividad_id'));
            $actividades = Actividad_Tecnico::where('actividad_id', $request->input('actividad_id'))->orderBy('horario_id', 'asc')->get();
            $horarios = Horario::get();
            $vehiculos = Vehiculo::get();
            $lista = Actividad_Tecnico::lista($request->input('actividad_id'));
            // return redirect()->route('actividades.asignar',['id',$request->input('actividad_id')])->with('status',$status);
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista','status','color'));
    }

    public function agregaValorMe($id)
    {
        $actividad = Actividad_Tecnico::find($id);
        return view('actividades.valor', compact('actividad'));
    }

    public function agregaValorMo($id)
    {
        $actividad = Actividad_Tecnico::find($id);
        return view('actividades.valor', compact('actividad'));
    }

    public function aprobarValorMe($id)
    {
        $actividad = Actividad_Tecnico::find($id);
        return view('actividades.valor', compact('actividad'));
    }

    public function aprobarValorMo($id)
    {
        $actividad = Actividad_Tecnico::find($id);
        return view('actividades.valor', compact('actividad'));
    }

    public function guardaValor(Request $request)
    {
        $this->validate($request, [
            'valor_metrico' => '',
            'valor_monetario' => '',
            'actividad_id' => ''
            ]);
            $actividadx = Actividad_Tecnico::find($request->input('actividad_id'));
            $actividadx->valor_metrico = $request->input('valor_metrico');
            $actividadx->valor_monetario = $request->input('valor_monetario');
            if($request->input('vmes') != null){
            $actividadx->vmes = $request->input('vmes');
            }
            if($request->input('vmos') != null){
            $actividadx->vmos = $request->input('vmos');
            }
            $actividadx->update();

            $id = auth()->user()->id;
            $accion = 'agregar valores a actividad';
            $tabla = 'actividad_tecnico';
            $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);

            $actividad = Actividad::find($request->input('id'));
            $actividades = Actividad_Tecnico::where('actividad_id', $request->input('id'))->orderBy('horario_id', 'asc')->get();
            $horarios = Horario::get();
            $vehiculos = Vehiculo::get();
            $lista = Actividad_Tecnico::lista($request->input('id'));
            $status = '';
            return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista', 'status'));
    }

    public function asignacionUpdate(Request $request, $id)
    {
        $post = $request->all();
        $actividadx = Actividad_Tecnico::find( $post['actividad_id']);
        $actividadx->actividad_id = $post['actividad_id'];
        $actividadx->horario_id = $post['horario_id'];
        $actividadx->vehiculo_id = $post['vehiculo_id'];
        $actividadx->actividad = $post['actividad'];
        $actividadx->update();

        $id = auth()->user()->id;
        $accion = 'actualizar asignacion';
        $tabla = 'actividad tecnico';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);

        $actividad = Actividad::find($post['actividad_id']);
        $actividades = Actividad_Tecnico::where('actividad_id', $post['actividad_id'])->orderBy('horario_id', 'asc')->get();
        $horarios = Horario::get();
        $vehiculos = Vehiculo::get();
        $lista = Actividad_Tecnico::lista($post['id']);
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista'));
    }

    public function asignacionDestroy($id, $actividad_id)
    {
        $actividad = Actividad_Tecnico::find($id);
        $actividad->delete();

        $id = auth()->user()->id;
        $accion = 'borrar asignacion';
        $tabla = 'actividad tecnico';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);

        $actividad = Actividad::find($actividad_id);
        $actividades = Actividad_Tecnico::where('actividad_id', '$actividad_id')->orderBy('horario_id', 'asc')->get();
        $horarios = Horario::get();
        $vehiculos = Vehiculo::get();
        $lista = Actividad_Tecnico::lista($actividad_id);
        $status = '';

        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista', 'status'));
    }
}
