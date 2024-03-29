@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-4">
                    <h3 class="page__heading">Técnico <b class="text-success">{{ $tecnico->nombre }}</b></h3>
                    <h3 class="page__heading">Reporte del <b class="text-success">{{ $fecha_final }}</b> al <b class="text-success">{{ $fecha_inicio }}</b></h3>
                </div>
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
                            <table id="reporte" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead class="bg-dark">
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Hora</td>
                                        <td>Valor Métrico</td>
                                        <td>Valor Monetario</td>
                                        <td>Vehículo - Actividad</td>
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
                                    <tbody>
                                        {{-- @foreach ($horarios as $horario)
                                        <tr>
                                            <td>{{ $horario->hora }}</td>

                                            @foreach ($lista as $item)
                                            @if ($item->hora == $horario->hora)
                                            <td>{{ $item->vehiculo }}</td>
                                            @else
                                            <td class="bg-warning">No hubo actividad</td>
                                            @endif
                                            @endforeach
                                        </tr>
                                        @endforeach --}}
                                        @foreach ($lista as $item)
                                        <tr>
                                        <td>{{ $item->fecha }}</td>
                                        <td>{{ $item->hora }}</td>
                                        @if ($item->valor_metrico == null)
                                        <td class="bg-danger">Aún no se le asigna</td>
                                        @else
                                        <td>{{ $item->valor_metrico }}</td>
                                        @endif
                                        @if ($item->valor_monetario == null)
                                        <td class="bg-danger">Aún no se le asigna</td>
                                        @else
                                        <td>{{ $item->valor_monetario }}</td>
                                        @endif
                                        <td>{{ $item->vehiculo .' - '. $item->actividad }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
