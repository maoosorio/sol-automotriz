@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                {{-- <div class="col-md-6 col-xl-6">
                                        <div class="card bg-primary">
                                                <div class="card-header">
                                                <h4>Usuarios</h4>
                                                    @php
                                                    use App\Models\User;
                                                    $cant_usuarios = User::count();
                                                    @endphp
                                                    <h2 class="text-right"><i class="fa fa-users fa-2x fa-pull-left"></i>
                                                        <span>{{$cant_usuarios}}</span></h2>
                                                    <p class="text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                                                </div>
                                        </div>
                                    </div> --}}

                                {{-- <div class="col-md-6 col-xl-6">
                                        <div class="card bg-success">
                                            <div class="card-header">
                                            <h4>Roles</h4>
                                                @php
                                                use Spatie\Permission\Models\Role;
                                                 $cant_roles = Role::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-user-lock fa-2x fa-pull-left"></i>
                                                    <span>{{$cant_roles}}</span></h2>
                                                <p class="text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div> --}}

                                <div class="col-md-6 col-xl-6">
                                    <div class="card bg-success">
                                        <div class="card-header">
                                            <h4>Administrativos</h4>
                                            @php
                                                use App\Models\Tecnico;
                                                // if(auth()->user()->sucursal_id == 1) {
                                                $cant_administrativos = Tecnico::where('tipo', 'Administrativo')->count();
                                                // }else{
                                                //     $sucursal_id = auth()->user()->sucursal_id;
                                                //     $cant_administrativos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Administrativo']])->count();
                                                // }
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-user-lock fa-2x fa-pull-left"></i>
                                                <span>{{ $cant_administrativos }}</span>
                                            </h2>
                                            <p class="text-right"><a href="/administrativos" class="text-white">Ver más</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-6">
                                    <div class="card bg-warning">
                                        <div class="card-header">
                                            <h4>Técnicos</h4>
                                            @php
                                                // if(auth()->user()->sucursal_id == 1) {
                                                $cant_tecnicos = Tecnico::where('tipo', 'Tecnico')->count();
                                                // }else{
                                                //     $sucursal_id = auth()->user()->sucursal_id;
                                                //     $cant_tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Tecnico']])->count();
                                                // }
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-user-lock fa-2x fa-pull-left"></i>
                                                <span>{{ $cant_tecnicos }}</span>
                                            </h2>
                                            <p class="text-right"><a href="/tecnicos" class="text-white">Ver más</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-6">
                                    <div class="card bg-danger">
                                        <div class="card-header">
                                            <h4>Vehículos</h4>
                                            @php
                                                use App\Models\Vehiculo;
                                                // if(auth()->user()->sucursal_id == 1) {
                                                    $cant_vehiculos = Vehiculo::count();
                                                // }else{
                                                //     $sucursal_id = auth()->user()->sucursal_id;
                                                //     $cant_vehiculos = Vehiculo::where('sucursal_id', $sucursal_id)->count();
                                                // }
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-user-lock fa-2x fa-pull-left"></i>
                                                <span>{{ $cant_vehiculos }}</span>
                                            </h2>
                                            <p class="text-right"><a href="/vehiculos" class="text-white">Ver
                                                    más</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
