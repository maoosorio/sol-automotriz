<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnico;

class TecnicoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ver-tecnico|crear-tecnico|editar-tecnico|borrar-tecnico', ['only' => ['index']]);
         $this->middleware('permission:crear-tecnico', ['only' => ['create','store']]);
         $this->middleware('permission:editar-tecnico', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-tecnico', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tecnicos = Tecnico::all();
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
        return view('tecnicos.crear',compact('tecnicos'));
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
        $tecnicos = Tecnico::create(['nombre' => $request->input('nombre')]);
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
        return view('tecnicos.editar', compact('tecnico'));
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
        $tecnico->update();
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
        return redirect()->route('tecnicos.index');
    }
}
