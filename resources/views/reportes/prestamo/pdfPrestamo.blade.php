<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Préstamos</title>
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
            <h3>Reporte de Préstamos</h3>
        </div>
    </div>
    <div>
        <div>
            <table>
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Monto</td>
                        <td>Estado</td>
                        <td>Sucursal</td>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        @foreach ($prestamos as $item)
                        <tr>
                        <td>{{ $item->tecnico->nombre }}</td>
                        <td>{{ $item->monto }}</td>
                        <td>
                        @php
                            if($item->estado == 0){
                            echo "<b>Pagado</b>";
                            }if($item->estado == 1){
                            echo "<b>No Pagado</b>";
                            }
                        @endphp
                        </td>
                        <td>{{ $item->tecnico->sucursal->nombre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>
