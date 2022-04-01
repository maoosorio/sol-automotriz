<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnico;
use App\Models\Sucursal;
use App\Models\UsuarioLog;

class TecnicoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:2.2 ver-tecnico|2.2.1 crear-tecnico|2.2.2 editar-tecnico|2.2.3 borrar-tecnico', ['only' => ['index']]);
         $this->middleware('permission:2.2.1 crear-tecnico', ['only' => ['create','store']]);
         $this->middleware('permission:2.2.2 editar-tecnico', ['only' => ['edit','update']]);
         $this->middleware('permission:2.2.3 borrar-tecnico', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->sucursal_id == 1) {
            $tecnicos = Tecnico::where('tipo','Tecnico')->get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Tecnico']])->get();
        }
        return view('tecnicos.index',compact('tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnicos = Tecnico::get();
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        return view('tecnicos.crear',compact('tecnicos','sucursales'));
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
            'tipo' => 'required',
            'sucursal_id' => 'required',
        ]);
        $tecnicos = Tecnico::create(['nombre' => $request->input('nombre'),'tipo' => $request->input('tipo'),'sucursal_id' => $request->input('sucursal_id')]);

        $id = auth()->user()->id;
        $accion = 'crear tecnico';
        $tabla = 'tecnico';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('tecnicos.index');
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
        $tecnico = Tecnico::find($id);
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        return view('tecnicos.editar', compact('tecnico','sucursales'));
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
        $tecnico = Tecnico::find($id);
        $tecnico->nombre = $request->input('nombre');
        $tecnico->sucursal_id = $request->input('sucursal_id');
        $tecnico->update();

        $id = auth()->user()->id;
        $accion = 'actualizar tecnico';
        $tabla = 'tecnico';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('tecnicos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tecnico = Tecnico::find($id);
        $tecnico->delete();

        $id = auth()->user()->id;
        $accion = 'borrar tecnico';
        $tabla = 'tecnico';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('tecnicos.index');
    }
}
