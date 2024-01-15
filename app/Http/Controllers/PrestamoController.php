<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Prestamo_Tecnico;
use App\Models\Tecnico;
use App\Models\Sucursal;
use App\Models\UsuarioLog;

class PrestamoController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:6 ver-prestamo|6.1 crear-prestamo|6.2 ver-pagos', ['only' => ['index']]);
         $this->middleware('permission:6.1 crear-prestamo', ['only' => ['create','store']]);
         $this->middleware('permission:6.2 ver-pagos', ['only' => ['edit']]);
         $this->middleware('permission:6.3 agregar-pago', ['only' => ['update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->sucursal_id == 1) {
            $prestamos = Prestamo::where('estado',1)->get();
            $tecnicos = Tecnico::get();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $prestamos = Prestamo::where('estado',1)->get();
            $tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id]])->get();
        }
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        return view('prestamos.index',compact('prestamos','tecnicos','sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::where('nombre', 'not like', "Todas")->get();
        if(auth()->user()->sucursal_id == 1) {
            $tecnicos = Tecnico::listaTecnico();
        }else{
            $sucursal_id = auth()->user()->sucursal_id;
            $tecnicos = Tecnico::listaTecnico();
        }
        // $sucursales = Sucursal::get();
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
            // 'tipo' => 'required',
        ]);
        $prestamos = Prestamo::create(['tecnico_id' => $request->input('tecnico_id'),'monto' => $request->input('monto'),'pagos' => $request->input('pagos'),'estado' => $request->input('estado')]);

        $prestamo_id = $prestamos->id;
        $prestamo_pago = $prestamos->pagos;
        $prestamo_monto = $prestamos->monto;
        $monto = $prestamo_monto / $prestamo_pago;
        // $prestamo_tipo = $prestamos->tipo;

        for($i = 0; $i < $prestamo_pago; $i++) {
            $pagos = Prestamo_Tecnico::create(['prestamo_id' => $prestamo_id,'monto' => $monto]);
        }

        $id = auth()->user()->id;
        $accion = 'crear prestamo';
        $tabla = 'prestamo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
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
        $prestamoss = Prestamo_Tecnico::where(['prestamo_id'=>$id,'estado'=>null])->count();
        // $prestamos = Prestamo_Tecnico::where(['prestamo_id'=>$id,'estado'=>null])->count();
        // dd($prestamos);
        // die();

        return view('prestamos.editar', compact('prestamo','prestamos','prestamoss'));
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
        $this->validate($request, [
            'id' => 'required',
        ]);

        $idp = $request->input('id');
        $hoy = date('Y-m-d');
        $prestamo = Prestamo_Tecnico::find($idp);
        $prestamo->estado = 'Pagado';
        $prestamo->fecha = $hoy;
        $prestamo->update();

        $prestamos = Prestamo_Tecnico::where(['prestamo_id'=>$id,'estado'=>null])->count();
        if($prestamos == 0){
        $prestamop = Prestamo::find($id);
        $prestamop->estado = 0;
        $prestamop->update();
        }

        $id = auth()->user()->id;
        $accion = 'actualizar pago';
        $tabla = 'pago';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('prestamos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prestamo = Prestamo::find($id);
        $prestamo->delete();

        $id = auth()->user()->id;
        $accion = 'borrar prestamo';
        $tabla = 'prestamo';
        $log = UsuarioLog::create(['usuario_id' => $id, 'accion' => $accion, 'tabla' => $tabla]);
        return redirect()->route('prestamos.index');
    }
}
