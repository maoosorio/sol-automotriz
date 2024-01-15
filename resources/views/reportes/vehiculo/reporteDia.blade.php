@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-8">
                    <h3 class="page__heading">Reporte de Vehículos <b class="text-success">{{ $fecha_inicio }}</b></h3>
                </div>
                {{-- <div class="col-4"></div> --}}
                <div class="col-4">
                    @php
                        use App\Models\Sucursal;
                        $id = auth()->user()->sucursal_id;
                        $sucur = Sucursal::find($id);
                    @endphp
                    <p class="text-primary text-right">Sucursal: {{ $sucur->nombre }}
                    </p>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <a href="{{  route('pdf.vehiculosDia', $fecha_inicio) }}" target="blank" class="btn btn-primary">Descargar PDF</a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    @foreach ($listaVehiculos as $vehiculo)
                                        <div class="card mb-3">
                                            <div class="card-header bg-light">
                                                <h5>{{ $vehiculo->vehiculo }}</h5>
                                                <span @php
                                                    if ($vehiculo->estado == 'Activo') {
                                                        echo 'class="btn btn-success"';
                                                    } else {
                                                        echo 'class="btn btn-danger"';
                                                    }
                                                @endphp>{{ $vehiculo->estado }}</span>
                                            </div>
                                            <div class="card-body">
                                                <p><span class="btn btn-warning">Actividades</span></p>
                                                @foreach ($horarios as $horario)
                                                    @foreach ($listaActividades as $actividad)
                                                        @if ($horario->id == $actividad->horario_id && $vehiculo->id == $actividad->vehiculo_id)
                                                            <p class="card-text">
                                                                <span
                                                                    class="btn btn-secondary">{{ $horario->hora }}</span>
                                                                <span
                                                                    class="btn btn-primary">{{ $actividad->actividad }}</span>
                                                                <span
                                                                    class="btn btn-light">{{ $actividad->nombre }}</span>
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
