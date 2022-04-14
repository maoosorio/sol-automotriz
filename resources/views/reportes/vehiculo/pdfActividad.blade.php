<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Actividad a Vehículo</title>
    <link href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css">
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
                <img src="{{ public_path('vendor/adminlte/dist/img/logo.png') }}" height="70px" alt="">
                <h3>Reporte de Vehículo: {{ $vehiculo->vehiculo }}</h3>
            </div>
            <table>
                    <tr>
                        <td>Hora/Fecha</td>
                        @foreach ( $fechas as $fecha )
                        <td>{{ $fecha }}</td>
                        @endforeach
                    </tr>
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
            </table>
        </div>

</body>

</html>
