<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Sucursal_Usuario;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UsuarioController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:1.2 ver-usuario|1.2.1 crear-usuario|1.2.2 editar-usuario|1.2.3 asignar-sucursal|1.2.4 borrar-usuario', ['only' => ['index']]);
         $this->middleware('permission:1.2.1 crear-usuario', ['only' => ['create','store']]);
         $this->middleware('permission:1.2.2 editar-usuario', ['only' => ['edit','update']]);
         $this->middleware('permission:1.2.3 asignar-sucursal', ['only' => ['asignar','asignacion']]);
         $this->middleware('permission:1.2.4 borrar-usuario', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = User::all();
        return view('usuarios.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $sucursales = Sucursal::get();
        return view('usuarios.crear',compact('roles','sucursales'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
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
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('usuarios.editar',compact('user','roles','userRole'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    public function asignar($id)
    {
        $user = User::find($id);
        $sucursales = Sucursal::all();
        $usuarios = Sucursal_Usuario::where('usuario_id',$id)->get();
        return view('usuarios.asignar',compact('user','sucursales','usuarios'));
    }

    public function asignacion(Request $request, $id)
    {
        $this->validate($request, [
            'usuario_id' => 'required',
            'sucursal_id' => 'required',
        ]);

        $input = $request->all();
        $user = User::find($id);
        $user = Sucursal_Usuario::create($input);

        return redirect()->route('usuarios.index');
    }

    public function asignacionDestroy($id)
    {
        Sucursal_Usuario::find($id)->delete();
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}
