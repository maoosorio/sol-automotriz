<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ver-vehiculo|crear-vehiculo|editar-vehiculo|borrar-vehiculo', ['only' => ['index']]);
         $this->middleware('permission:crear-vehiculo', ['only' => ['create','store']]);
         $this->middleware('permission:editar-vehiculo', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-vehiculo', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Vehiculo::all();
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
        return view('vehiculos.crear',compact('vehiculos'));
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
        ]);
        $vehiculo = Vehiculo::create(['vehiculo' => $request->input('vehiculo'),'placa' => $request->input('placa')]);
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
        return view('vehiculos.editar', compact('vehiculo'));
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
        $vehiculo->update();
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
        return redirect()->route('vehiculos.index');
    }
}
