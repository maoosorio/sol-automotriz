@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-8">
                    <h3 class="page__heading">Vehículo <b class="text-success">{{ $vehiculo->vehiculo }}</b></h3>
                    <h3 class="page__heading">Reporte del <b class="text-success">{{ $fecha_final }}</b> al <b class="text-success">{{ $fecha_inicio }}</b></h3>
                </div>

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

                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                <a href="{{  route('pdf.vehiculoActividad', [$fecha_inicio,$vehiculo->id]) }}" target="blank" class="btn btn-primary">Descargar PDF</a>
                            </div>

                            <table id="reporte" class="table table-responsive table-fluid table-striped table-bordered mt-2" with-buttons>

                                <thead class="bg-dark">
                                    <tr>
                                        <td>Hora/Fecha</td>
                                        @foreach ( $fechas as $fecha )
                                        <td>{{ $fecha }}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    @foreach ( $horarios as $horario )
                                    <td><b>{{ $horario->hora }}</b></td>
                                    @foreach ( $fechas as $fecha )
                                    @foreach ( $lista as $row )
                                        @if ( $horario->hora == $row->hora && $fecha == $row->fecha )
                                            <td>{{ $row->actividad }} - {{ $row->nombre }}</td>
                                        {{-- @else
                                            <td class="text-danger">Sin actividad</td> --}}
                                        @endif
                                    @endforeach
                                    @endforeach
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
