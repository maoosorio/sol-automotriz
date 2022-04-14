<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Asistencia Técnica</title>
    {{-- <link href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <style>

    </style>
</head>

<body>
<div>
    <div>
        <div>
            <img src="{{ public_path('vendor/adminlte/dist/img/logo.png') }}" height="70px" alt="">
            <h3>Reporte de Asistencia Técnica</h3>
        </div>
    </div>
    <div>
        <div>
            <table>
                <thead>
                    <th>Etapa</th>
                    <th>Vehiculo</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                </thead>
                <tbody>
                    @foreach ($vehiculos as $vehiculo)
                        <tr>
                            <td>{{ $vehiculo->etapa }}</td>
                            <td>{{ $vehiculo->vehiculo }}</td>
                            <td>{{ $vehiculo->nombre }}</td>
                            <td>{{ $vehiculo->fecha }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>
