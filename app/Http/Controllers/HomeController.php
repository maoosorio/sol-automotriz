<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Sucursal_Usuario;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->user()->id;
        $sucursal_id = auth()->user()->sucursal_id;
        // if ($sucursal_id == null){
            $sucursal = User::find($id)->sucursal->count();
            if ($sucursal >= 2){
                $user = User::find($id);
                $sucursales = User::find($id);
                return view('sucursal', compact('sucursales','user'));
            }else{
            //     $sucursal = User::find($id)->sucursal;
            //     foreach($sucursal as $fila){
            //         $fila->id;
            // }
            // $user = User::find($id);
            // $user->sucursal_id = $fila->id;
            // $user->save();
                return view('inicio');
            }
        // }else{
            // $user = User::find($id);
            // $user->sucursal_id = null;
            // $user->save();
            // return view('home');
        // }
    }

    public function sucursal()
    {
        $id = auth()->user()->id;
        $sucursales = User::find($id);
        $user = User::find($id);
        return view('sucursal', compact('sucursales','user'));
    }

    public function asociar(Request $request, $id)
    {
        $this->validate($request, [
            'sucursal_id' => 'required',
        ]);
        $input = $request->all();
        $user = User::find($id);
        $user->sucursal_id = $request['sucursal_id'];
        $user->save();

        return redirect()->route('inicio');
    }

    public function inicio()
    {
        return view('inicio');
    }

}
