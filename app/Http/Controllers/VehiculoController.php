<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Sucursal;
use App\Models\UsuarioLog;

class VehiculoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:3 ver-vehiculo|3.1 crear-vehiculo|3.2 editar-vehiculo|3.3 borrar-vehiculo', ['only' => ['index']]);
         $this->middleware('permission:3.1 crear-vehiculo', ['only' => ['create','store']]);
         $this->middleware('permission:3.2 editar-vehiculo', ['only' => ['edit','update']]);
         $this->middleware('permission:3.3 borrar-vehiculo', ['only' => ['destroy']]);
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
