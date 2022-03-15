@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Vehículo <b class="text-success">{{ $vehiculo->vehiculo }}</b></h3>
            <h3 class="page__heading">Reporte del <b class="text-success">{{ $fecha_final }}</b> al <b class="text-success">{{ $fecha_inicio }}</b></h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="reporte" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead class="bg-dark">
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Hora</td>
                                        <td>Técnico - Actividad</td>
                                        {{-- @for ($i = $fecha_final; $i < $fecha_inicio; $i++)

                                        @endfor --}}
                                    {{-- @php
                                    function dias($date)
                                    {
                                    if($date == 'Sun') return 'Dom';
                                    if($date == 'Mon') return 'Lun';
                                    if($date == 'Tue') return 'Mar';
                                    if($date == 'Wed') return 'Mie';
                                    if($date == 'Thu') return 'Jue';
                                    if($date == 'Fri') return 'Vie';
                                    if($date == 'Sat') return 'Sab';
                                    }
                                        $fechaInicio=strtotime($fecha_final);
                                        $fechaFin=strtotime($fecha_inicio);
                                        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                            $fecha = date("d-m-Y", $i);
                                            $dia=date("w", strtotime($fecha));
                                            $dial=date("D", strtotime($fecha));
                                            if($dia == 0){
                                            }
                                            else{
                                        echo "<td>". dias($dial) ." - ".date("d-m", $i) ."</td>";
                                            }
                                        }
                                    @endphp --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($horarios as $horario) --}}
                                        {{-- <td>{{ $horario->hora }}</td> --}}

                                        @foreach ($lista as $item)
                                        <tr>
                                        {{-- @if ($item->pivot->hora == $horario->hora) --}}
                                        <td>{{ $item->fecha }}</td>
                                        <td>{{ $item->hora }}</td>
                                        <td>{{ $item->nombre .' - '. $item->actividad }}</td>
                                        {{-- @else --}}
                                        {{-- <td class="bg-warning">No hubo actividad</td> --}}
                                        {{-- @endif --}}
                                        </tr>
                                        @endforeach
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
