<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\Vehiculo;
use App\Models\Alta;
use App\Models\UsuarioLog;

class Altacontroller extends Controller
{

    function __construct()
    {
         $this->middleware('permission:7 ver-alta|7.1 crear-alta|7.2 editar-alta|7.3 borrar-alta', ['only' => ['index']]);
         $this->middleware('permission:7.1 crear-alta', ['only' => ['create','store']]);
         $this->middleware('permission:7.2 editar-alta', ['only' => ['edit','update']]);
         $this->middleware('permission:7.3 borrar-alta', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->sucursal_id == 1) {
            $altas = Alta::get();
            $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $altas = Alta::where([['sucursal_id', '=', $sucursal_id]])->get();
            $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        }
        return view('altas.index',compact('altas','sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','Activo')->get();
            $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
            return view('altas.crear',['sucursales' => $sucursales],compact('vehiculos'));
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id], ['estado', '=', 'activo']])->get();
            $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        }
        return view('altas.crear', compact('vehiculos','sucursales'));
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
            'vehiculo_id' => 'required',
            'sucursal_id' => 'required',
            'fecha' => 'required',
            'usuario_id' => 'required',
        ]);

        $vehiculo = Vehiculo::find($request->input('vehiculo_id'));
        $vehiculo->estado = ('Alta');
        $vehiculo->alta = ($request->input('fecha'));
        $vehiculo->update();

        $altas = Alta::create(['vehiculo_id' => $request->input('vehiculo_id'),'sucursal_id' => $request->input('sucursal_id'),'fecha' => $request->input('fecha'),'usuario_id' => $request->input('usuario_id')]);

        $id = auth()->user()->id;
        $accion = 'crear alta';
        $tabla = 'alta';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('altas.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $altas = Alta::find($id);

        $vehiculo = Vehiculo::find($altas->vehiculo_id);
        $vehiculo->estado = ('Activo');
        $vehiculo->update();

        $altas->delete();

        $id = auth()->user()->id;
        $accion = 'borrar alta';
        $tabla = 'alta';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('altas.index');
    }
}
