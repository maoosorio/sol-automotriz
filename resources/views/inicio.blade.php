@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Dashboard</h3>
                <div class="col-4"></div>
                <div class="col-4">
                    @php
                    use App\Models\Sucursal;
                    $id = auth()->user()->sucursal_id;
                    $sucur = Sucursal::find($id) ;
                    @endphp
                    <p class="text-primary text-right">Sucursal: {{ $sucur->nombre }}
                    </p></div>
                </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-xl-6">
                                    <div class="card bg-success">
                                        <div class="card-header">
                                            <h4>Administrativos</h4>
                                            @php
                                                use App\Models\Tecnico;
                                                if(auth()->user()->sucursal_id == 1) {
                                                $cant_administrativos = Tecnico::where('tipo', 'Administrativo')->count();
                                                }else{
                                                    $sucursal_id = auth()->user()->sucursal_id;
                                                    $cant_administrativos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Administrativo']])->count();
                                                }
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
                                                if(auth()->user()->sucursal_id == 1) {
                                                $cant_tecnicos = Tecnico::where('tipo', 'Tecnico')->count();
                                                }else{
                                                    $sucursal_id = auth()->user()->sucursal_id;
                                                    $cant_tecnicos = Tecnico::where([['sucursal_id', '=', $sucursal_id], ['tipo', '=', 'Tecnico']])->count();
                                                }
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
                                                if(auth()->user()->sucursal_id == 1) {
                                                    $cant_vehiculos = Vehiculo::count();
                                                }else{
                                                    $sucursal_id = auth()->user()->sucursal_id;
                                                    $cant_vehiculos = Vehiculo::where('sucursal_id', $sucursal_id)->count();
                                                }
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
