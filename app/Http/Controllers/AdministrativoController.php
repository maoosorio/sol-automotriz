<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnico;
use App\Models\Sucursal;
use App\Models\Sucursal_Usuario;

class AdministrativoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:2.1 ver-administrativo|2.1.1 crear-administrativo|2.1.2 editar-administrativo|2.1.3 borrar-administrativo', ['only' => ['index']]);
         $this->middleware('permission:2.1.1 crear-administrativo', ['only' => ['create','store']]);
         $this->middleware('permission:2.1.2 editar-administrativo', ['only' => ['edit','update']]);
         $this->middleware('permission:2.1.3 borrar-administrativo', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth()->user()->sucursal_id == 1) {
            $administrativos = Tecnico::where('tipo','Administrativo')->get();
        // }else{
            // $sucursal_id = auth()->user()->sucursal_id;
            // $administrativos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Administrativo']])->get();
        // }
        return view('administrativos.index',compact('administrativos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $administrativos = Tecnico::get();
        $sucursales = Sucursal::get();
        return view('administrativos.crear',compact('administrativos','sucursales'));
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
        $administrativos = Tecnico::create(['nombre' => $request->input('nombre'),'tipo' => $request->input('tipo'),'sucursal_id' => $request->input('sucursal_id')]);
        return redirect()->route('administrativos.index');
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
        $administrativo = Tecnico::find($id);
        $sucursales = Sucursal::get();
        return view('administrativos.editar', compact('administrativo','sucursales'));
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
        $administrativo = Tecnico::find($id);
        $administrativo->nombre = $request->input('nombre');
        $administrativo->sucursal_id = $request->input('sucursal_id');
        $administrativo->update();
        return redirect()->route('administrativos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $administrativo = Tecnico::find($id);
        $administrativo->delete();
        return redirect()->route('administrativos.index');
    }
}
