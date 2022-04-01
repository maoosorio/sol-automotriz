<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\UsuarioLog;

class SucursalController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:1.1 ver-sucursal|1.1.1 crear-sucursal|1.1.2 editar-sucursal|1.1.3 borrar-sucursal', ['only' => ['index']]);
         $this->middleware('permission:1.1.1 crear-sucursal', ['only' => ['create','store']]);
         $this->middleware('permission:1.1.2 editar-sucursal', ['only' => ['edit','update']]);
         $this->middleware('permission:1.1.3 borrar-sucursal', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursales.index',compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::get();
        return view('sucursales.crear',compact('sucursales'));
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
            'nombre' => 'required',
        ]);
        $sucursales = Sucursal::create(['nombre' => $request->input('nombre')]);

        $id = auth()->user()->id;
        $accion = 'crear sucursal';
        $tabla = 'sucursal';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('sucursales.index');
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
        $sucursal = Sucursal::find($id);
        return view('sucursales.editar', compact('sucursal'));
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
        $sucursal = Sucursal::find($id);
        $sucursal->nombre = $request->input('nombre');
        $sucursal->update();

        $id = auth()->user()->id;
        $accion = 'actualizar sucursal';
        $tabla = 'sucursal';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('sucursales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);
        $sucursal->delete();

        $id = auth()->user()->id;
        $accion = 'borrar sucursal';
        $tabla = 'sucursal';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('sucursales.index');
    }
}
