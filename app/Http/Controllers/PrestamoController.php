<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Prestamo_Tecnico;
use App\Models\Tecnico;
use App\Models\Sucursal;

class PrestamoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:6 ver-prestamo|6.1 crear-prestamo|6.2 editar-prestamo|6.3 borrar-prestamo', ['only' => ['index']]);
         $this->middleware('permission:6.1 crear-prestamo', ['only' => ['create','store']]);
         $this->middleware('permission:6.2 editar-prestamo', ['only' => ['edit','update']]);
         $this->middleware('permission:6.3 borrar-prestamo', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth()->user()->sucursal_id == 1) {
            $prestamos = Prestamo::where('estado','1')->get();
            $tecnicos = Tecnico::get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $prestamos = Prestamo::where('estado','activo')->get();
        //     $tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id]])->get();
        // }
        $sucursales = Sucursal::get();
        return view('prestamos.index',compact('prestamos','tecnicos','sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $sucursales = Sucursal::get();
        // if(auth()->user()->sucursal_id == 1) {
            $tecnicos = Tecnico::get();
        // }else{
        //     $sucursal_id = auth()->user()->sucursal_id;
        //     $tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id]])->get();
        // }
        $sucursales = Sucursal::get();
        return view('prestamos.crear',compact('sucursales','tecnicos'));
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
            'tecnico_id' => 'required',
            'monto' => 'required',
            'pagos' => 'required',
            'estado' => 'required',
        ]);
        $prestamos = Prestamo::create(['tecnico_id' => $request->input('tecnico_id'),'monto' => $request->input('monto'),'pagos' => $request->input('pagos'),'estado' => $request->input('estado')]);
        return redirect()->route('prestamos.index');
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
        $prestamo = Prestamo::find($id);

        $prestamos = Prestamo_Tecnico::where('prestamo_id',$id)->get();
        return view('prestamos.editar', compact('prestamo','prestamos'));
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
        //
    }
}
