<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Vehículos por Día</title>
    {{-- <link href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid;
        }

    </style>
</head>

<body>
<div>
    <div>
        <div>
            <img src="{{ public_path('vendor/adminlte/dist/img/logo.png') }}" height="70px" alt="">
            <h3>Reporte de Vehículos de: {{ $fecha }}</h3>
        </div>
    </div>
    <div>
        <div>
            @foreach ($listaVehiculos as $vehiculo)
                <table>
                    <tr>
                        <td><b>{{ $vehiculo->vehiculo }}</b> - {{ $vehiculo->estado }}</td>
                    </tr>
                    <tr>
                        <td>Actividades</td>
                    </tr>
                    @foreach ($horarios as $horario)
                        @foreach ($listaActividades as $actividad)
                            @if ($horario->id == $actividad->horario_id && $vehiculo->id == $actividad->vehiculo_id)
                                <tr>
                                    <td><b>{{ $horario->hora }}</b> | {{ $actividad->actividad }} | <i>{{ $actividad->nombre }}</b></td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </table><br><br>
            @endforeach

        </div>
    </div>
</div>

</body>

</html>
