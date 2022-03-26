<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traslado;
use App\Models\Sucursal;
use App\Models\Vehiculo;

class TrasladoController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:4 ver-traslado|4.1 crear-traslado|4.2 editar-traslado|4.3 borrar-traslado', ['only' => ['index']]);
         $this->middleware('permission:4.1 crear-traslado', ['only' => ['create','store']]);
         $this->middleware('permission:4.2 editar-traslado', ['only' => ['edit','update']]);
         $this->middleware('permission:4.4 borrar-traslado', ['only' => ['destroy']]);
         $this->middleware('permission:4.3 aprobar-traslado', ['only' => ['aprobar','aprobacion']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth()->user()->sucursal_id == 1) {
            $traslados = Traslado::get();
            $vehiculos = Vehiculo::where('estado','Activo')->get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $traslados = Traslado::where('sucursal_origen', $sucursal_id)->orWhere('sucursal_destino', $sucursal_id)->get();
        //     $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado','Activo']])->get();
        // }
        $sucursales = Sucursal::get();
        return view('traslados.index',compact('traslados','sucursales','vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::get();
        // if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','Activo')->get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado','Activo']])->get();
        // }
        return view('traslados.crear',compact('sucursales','vehiculos'));
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
            'sucursal_origen' => 'required',
            'sucursal_destino' => 'required',
            'vehiculo_id' => 'required',
            'usuario_id' => 'required',
            'estado' => 'required',
            'observaciones' => 'required',
            'link' => 'required',
        ]);
        $traslados = Traslado::create(['sucursal_origen' => $request->input('sucursal_origen'),'sucursal_destino' => $request->input('sucursal_destino'),'vehiculo_id' => $request->input('vehiculo_id'),'usuario_id' => $request->input('usuario_id'),'observaciones' => $request->input('observaciones'),'link' => $request->input('link'),'estado' => $request->input('estado')]);
        return redirect()->route('traslados.index');
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
        $traslado = Traslado::find($id);
        $sucursales = Sucursal::get();
        // if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','Activo')->get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado','Activo']])->get();
        // }
        return view('traslados.editar', compact('traslado','sucursales','vehiculos'));
    }

    public function aprobar($id)
    {
        $traslado = Traslado::find($id);
        $sucursales = Sucursal::get();
        // if(auth()->user()->sucursal_id == 1) {
            $vehiculos = Vehiculo::where('estado','Activo')->get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $vehiculos = Vehiculo::where([['sucursal_id', '=', $sucursal_id],['estado','Activo']])->get();
        // }
        return view('traslados.aprobar', compact('traslado','sucursales','vehiculos'));
    }

    public function aprobacion(Request $request, $id)
    {
        $this->validate($request, [
            'sucursal_destino' => 'required',
            'vehiculo_id' => 'required',
            'estado' => 'required',
        ]);

        if($request->input('estado') == 'Aprobado'){
            $traslado = Traslado::find($id);
            $traslado->estado = $request->input('estado');
            $vehiculo = Vehiculo::find($request->input('vehiculo_id'));
            $vehiculo->sucursal_id = $request->input('sucursal_destino');
            $vehiculo->update();
            $traslado->update();
        }
        if($request->input('estado') == 'Rechazado'){
            $traslado = Traslado::find($id);
            $traslado->estado = $request->input('estado');
            $traslado->update();
        }
        if($request->input('estado') == 'En Proceso'){
            $traslado = Traslado::find($id);
            $traslado->estado = $request->input('estado');
            $traslado->update();
        }

        return redirect()->route('traslados.index');
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
        $traslado = Traslado::find($id);
        $traslado->sucursal_origen = $request->input('sucursal_origen');
        $traslado->sucursal_destino = $request->input('sucursal_destino');
        $traslado->usuario_id = $request->input('usuario_id');
        $traslado->estado = $request->input('estado');
        $traslado->observaciones = $request->input('observaciones');
        $traslado->link = $request->input('link');
        $traslado->update();
        return redirect()->route('traslados.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $traslado = Traslado::find($id);
        $traslado->delete();
        return redirect()->route('traslados.index');
    }
}
