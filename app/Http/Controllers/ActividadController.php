<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Tecnico;
use App\Models\Vehiculo;
use App\Models\Horario;
use App\Models\Actividad_Tecnico;

class ActividadController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ver-actividad|crear-actividad|editar-actividad|borrar-actividad', ['only' => ['index']]);
         $this->middleware('permission:crear-actividad', ['only' => ['create','store']]);
         $this->middleware('permission:editar-actividad', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-actividad', ['only' => ['destroy']]);
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
        $actividades = Actividad::whereBetween('fecha', [$ayer, $hoy])->orderBy('fecha', 'asc')->all();
        $status = '';
        return view('actividades.index',compact('actividades','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actividades = Actividad::get();
        $tecnicos = Tecnico::get();
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
        $actividades = Actividad::create(['fecha' => $request->input('fecha'),'tecnico_id' => $request->input('tecnico_id')]);
        return redirect()->route('actividades.index');
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
        $tecnicos = Tecnico::get();
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
        $vehiculos = Vehiculo::get();
        $lista = Actividad_Tecnico::lista($id);
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista'));
    }

    public function asignacion(Request $request)
    {
        $this->validate($request, [
            'horario_id' => 'required',
            'actividad_id' => 'required',
            'vehiculo_id' => 'required',
            'actividad' => 'required',
            ]);
            $actividades = Actividad_Tecnico::create(['horario_id' => $request->input('horario_id'),'actividad_id' => $request->input('actividad_id'), 'vehiculo_id' => $request->input('vehiculo_id'),'actividad' => $request->input('actividad')]);
            $actividad = Actividad::find($request->input('actividad_id'));
            $actividades = Actividad_Tecnico::where('actividad_id', $request->input('actividad_id'))->orderBy('horario_id', 'asc')->get();
            $horarios = Horario::get();
            $vehiculos = Vehiculo::get();
            $lista = Actividad_Tecnico::lista($request->input('actividad_id'));
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista'));
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

        $actividad = Actividad::find($actividad_id);
        $actividades = Actividad_Tecnico::where('actividad_id', '$actividad_id')->orderBy('horario_id', 'asc')->get();
        $horarios = Horario::get();
        $vehiculos = Vehiculo::get();
        $lista = Actividad_Tecnico::lista($actividad_id);
        return view('actividades.asignar', compact('actividad', 'actividades', 'horarios', 'vehiculos', 'lista'));
    }
}
