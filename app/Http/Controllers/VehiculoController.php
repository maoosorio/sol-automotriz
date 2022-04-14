<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Sucursal;
use App\Models\UsuarioLog;
use App\Models\Etapa;
use App\Models\Proceso;
use App\Models\User;

class VehiculoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:3 ver-vehiculo|3.1 crear-vehiculo|3.2 editar-vehiculo|3.3 borrar-vehiculo|3.4 agregar-pat|3.5 borrar-pat|3.6 ver-pat', ['only' => ['index']]);
         $this->middleware('permission:3.1 crear-vehiculo', ['only' => ['create','store']]);
         $this->middleware('permission:3.2 editar-vehiculo', ['only' => ['edit','update']]);
         $this->middleware('permission:3.3 borrar-vehiculo', ['only' => ['destroy']]);
         $this->middleware('permission:3.4 agregar-pat', ['only' => ['agregarPAT']]);
         $this->middleware('permission:3.5 borrar-pat', ['only' => ['borrarPAT']]);
         $this->middleware('permission:3.6 ver-pat', ['only' => ['verPAT','indexPAT']]);
         $this->middleware('permission:3.6.1 agregar-proceso', ['only' => ['agregarProceso']]);
         $this->middleware('permission:3.6.2 borrar-proceso', ['only' => ['borrarProceso']]);
         $this->middleware('permission:3.6.1.1 agregar-etapa', ['only' => ['agregarEtapa']]);
         $this->middleware('permission:3.6.2.1 borrar-etapa', ['only' => ['borrarEtapa']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','activo')->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado', '=', 'activo']])->get();
        }
        return view('vehiculos.index',compact('vehiculos'));
    }

    public function indexPAT()
    {
        if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where([['estado', '=', 'activo'],['asesoria_tecnica','=',1]])->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado', '=', 'activo'],['asesoria_tecnica','=',1]])->get();
        }
        return view('vehiculos.indexPAT',compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiculos = Vehiculo::get();
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        return view('vehiculos.crear',compact('vehiculos','sucursales'));
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
            'vehiculo' => 'required',
            'placa' => 'required',
            'estado' => 'required',
            'sucursal_id' => 'required',
            'referencia' => 'required',
        ]);
        $vehiculo = Vehiculo::create(['vehiculo' => $request->input('vehiculo'),'placa' => $request->input('placa'),'estado' => $request->input('estado'),'sucursal_id' => $request->input('sucursal_id'),'referencia' => $request->input('referencia')]);

        $id = auth()->user()->id;
        $accion = 'crear vehiculo';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index');
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
        $vehiculo = Vehiculo::find($id);
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        return view('vehiculos.editar', compact('vehiculo','sucursales'));
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
        $vehiculo = Vehiculo::find($id);
        $vehiculo->vehiculo = $request->input('vehiculo');
        $vehiculo->placa = $request->input('placa');
        $vehiculo->estado = $request->input('estado');
        $vehiculo->sucursal_id = $request->input('sucursal_id');
        $vehiculo->referencia = $request->input('referencia');
        $vehiculo->update();

        $id = auth()->user()->id;
        $accion = 'actualizar vehiculo';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index');
    }

    public function agregarPAT(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->asesoria_tecnica = 1;
        $vehiculo->update();

        $id = auth()->user()->id;
        $accion = 'agregar vehiculo al pat';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index');
    }

    public function borrarPAT(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->asesoria_tecnica = null;
        $vehiculo->update();

        $id = auth()->user()->id;
        $accion = 'agregar vehiculo al pat';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index');
    }

    public function borrarPAT2(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->asesoria_tecnica = null;
        $vehiculo->update();

        $id = auth()->user()->id;
        $accion = 'agregar vehiculo al pat';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.indexPAT');
    }

    public function verPAT(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);
        $etapas = Etapa::where('vehiculo_id',$id);
        $status = '';
        return view('vehiculos.PAT', compact('vehiculo','etapas','status'));
        // return redirect()->route('vehiculos.verPAT')->with('vehiculo',$vehiculo);
    }

    public function agregarProceso(Request $request)
    {
        $this->validate($request, [
            'vehiculo_id' => 'required',
            'proceso' => 'required',
        ]);

        $vehiculo = Vehiculo::find($request->input('vehiculo_id'));

        $proceso = Proceso::create(['vehiculo_id' => $request->input('vehiculo_id'),'proceso' => $request->input('proceso')]);
        $status = '';

        $id = auth()->user()->id;
        $accion = 'agregar proceso de un vehiculo';
        $tabla = 'proceso';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.verPAT',['id' => $request->input('vehiculo_id')])->with('status',$status);

    }

    public function borrarProceso(Request $request, $id)
    {
        $proceso = Proceso::find($id);
        $proceso->delete();
        $status = '';

        $id = auth()->user()->id;
        $accion = 'borrar proceso al pat';
        $tabla = 'proceso';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index',['id' => $request->input('vehiculo_id')])->with('status',$status);
    }

    public function agregarEtapa(Request $request)
    {
        $this->validate($request, [
            'vehiculo_id' => 'required',
            'proceso_id' => 'required',
            'proceso_padre' => 'required',
            'etapa' => 'required',
            'valor' => 'required',
            'usuario_id' => 'required',
        ]);

        if($request->input('etapa') == 5){
        $vehiculo = Vehiculo::find($request->input('vehiculo_id'));

        $etapa = Etapa::create(['proceso_id' => $request->input('proceso_id'),'etapa' => $request->input('etapa'),'valor' => $request->input('valor'),'proceso_padre' => $request->input('proceso_padre'),'usuario_id' => $request->input('usuario_id')]);

        $proceso = Proceso::find($request->input('proceso_id'));
        $proceso->estado = 'Completo';
        $proceso->update();

        $status = '';
        }else{
        $vehiculo = Vehiculo::find($request->input('vehiculo_id'));

        $etapa = Etapa::create(['proceso_id' => $request->input('proceso_id'),'etapa' => $request->input('etapa'),'valor' => $request->input('valor'),'proceso_padre' => $request->input('proceso_padre'),'usuario_id' => $request->input('usuario_id')]);
        $status = '';
        }

        $id = auth()->user()->id;
        $accion = 'agregar proceso de un vehiculo';
        $tabla = 'proceso';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.verPAT',['id' => $request->input('vehiculo_id')])->with('status',$status);

    }

    public function borrarEtapa(Request $request, $id, $vehiculo_id)
    {
        $etapa = Etapa::find($id);
        $etapa->delete();
        $status = '';

        $id = auth()->user()->id;
        $accion = 'agregar vehiculo al pat';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.verPAT',['id' => $vehiculo_id])->with('status',$status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->delete();

        $id = auth()->user()->id;
        $accion = 'borrar vehiculo';
        $tabla = 'vehiculo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('vehiculos.index');
    }
}
